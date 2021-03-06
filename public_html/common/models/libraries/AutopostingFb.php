<?php
namespace common\models\libraries;

use common\models\AutopostingTasks;
use common\models\Mailer;
use common\models\Settings;
use Facebook\Authentication\OAuth2Client;
use Facebook\FacebookApp;
use Facebook\FacebookClient;

class AutopostingFb {

    const API_VERSION = '2.12';

    private $task;
    private $group_id;
    private $token;
    private $app_id;
    private $app_secret;
    private $fb_email;

    function __construct(AutopostingTasks $task){
        $this->task = $task;
        $settings = Settings::find()->one();
        $this->fb_email = $settings->fb_email;
        $this->app_id = (!$this->task->socialNetworksGroup->consumer_key) ? $settings->fb_app_id : $this->task->socialNetworksGroup->consumer_key;
        $this->app_secret = (!$this->task->socialNetworksGroup->consumer_secret) ? $settings->fb_app_secret : $this->task->socialNetworksGroup->consumer_key;
        $this->group_id = $this->task->socialNetworksGroup->group_id;
        $this->token = (!$this->task->socialNetworksGroup->token) ? $settings->fb_token : $this->task->socialNetworksGroup->token;

        $oauth2Fb = new OAuth2Client(new FacebookApp($this->app_id, $this->app_secret), new FacebookClient());
        try {
            $longLivedToken = $oauth2Fb->getLongLivedAccessToken($this->token);
        }catch(\Exception $e){
            \Yii::warning('АF P Ошибка публикации на странице Facebook', "DEBUG");
            TelegrammLoging::send('Ошибка Авторизации в API Facebook. '.$e->getMessage());
            Mailer::send(\Yii::$app->params['debugEmail'], "Ошибка API Facebook", 'api-error', [ 'request' => 'authorization', 'message' => $e->getMessage()]);

        }
        $this->token = $longLivedToken->getValue();
        $this->task->socialNetworksGroup->token = $longLivedToken->getValue();
        $this->task->socialNetworksGroup->save();

    }

    function post(){
        $postfields = [
            'message' => $this->task->ad->text,
            'access_token' => $this->token,
            'place' => $this->group_id,
            'published' => true,
            'link' => $this->task->ad->city->region->country->domain.'/'.$this->task->ad->url()
        ];
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/{$this->group_id}/feed");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER,  array("Content-Type:multipart/form-data"));
        curl_setopt($ch, CURLOPT_POSTFIELDS,  $postfields);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($response != 200){
            TelegrammLoging::send('Ошибка публикации на странице Facebook '.$this->task->socialNetworksGroup->group_id.' https://graph.facebook.com/'.$this->group_id.'/feed access_token => '.$this->token);
            Mailer::send(\Yii::$app->params['debugEmail'], "Ошибка API Facebook", 'api-error', [ 'request' => $this->task->socialNetworksGroup->group_id.' https://graph.facebook.com/'.$this->group_id.'/feed access_token => '.$this->token.', message =>'.$postfields['message'].', link => '.$postfields['link'], 'message' => 'Ошибка публикации на странице Facebook']);
            \Yii::warning('АF P Ошибка публикации на странице Facebook, задача '.$this->task->id, "DEBUG");
            $this->task->status = AutopostingTasks::STATUS_FAILED;
            $this->task->save();
        }else{
//            if($this->fb_email) {
//                \Yii::warning('АF P Маил отчет id'.$this->group_id.'@groups.facebook.com об успешной публикации задачи '.$this->task->id, "DEBUG");
//                Mailer::send("id$this->group_id@groups.facebook.com", $this->task->ad->title, 'fb-publication', ['ad' => $this->task->ad], ['name' => 'Obiavo.ru', 'email' => 'df200587@mail.ru']);
//            }
            $this->task->status = AutopostingTasks::STATUS_POSTED;
            $this->task->save();
            \Yii::warning('АF P Успешная публикация, задача '.$this->task->id, "DEBUG");
        }
    }
}