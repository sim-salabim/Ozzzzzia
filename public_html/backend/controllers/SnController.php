<?php
namespace backend\controllers;

use common\helpers\JsonData;
use common\models\Country;
use common\models\SocialNetworks;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class SnController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex($sn_id = null){
        $sn = null;

        if ($sn_id){
            $sn = SocialNetworks::findOne($sn_id);
        } else {
            $social_networks = SocialNetworks::find()->orderBy('order ASC')->all();
        }

        return $this->render('index',  compact('sn', 'social_networks'));
    }

    public function actionOrderCountryList(){
        $countries = Country::find()->withText()->all();

        return $this->render('order/index',  compact('countries'));
    }

    public function actionSnOrder(){
        $sns = SocialNetworks::find()
            ->where(['active' => 1])
            ->orderBy(['order' => SORT_ASC])
            ->all();

        $homeLink = ['label' => 'Настройка порядка вывода блоков групп соцсетей', 'url' => '/sn/order-sn-list'];
        $breadcrumbs = \yii\widgets\Breadcrumbs::widget([
            'homeLink' => $homeLink
        ]);
        return $this->render('order/sn-order',  compact('sns', 'breadcrumbs'));
    }

    public function actionSaveOrder(){
        $post = Yii::$app->request->post();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if(count($post['sn_order'])){
            foreach($post['sn_order'] as $k => $r){
                $sn = SocialNetworks::findOne($r);
                $sn->order = $k;
                $sn->save();
            }
        }
        $this->redirect("/sn");
    }

    public function actionCreate(){
        $sn = new SocialNetworks();

        $toUrl = Url::toRoute(['save']);

        return $this->render('form',  compact('sn','toUrl'));
    }

    public function actionUpdate($id){
        $sn = SocialNetworks::find()
            ->where(['id' => $id])->one();

        $toUrl = Url::toRoute(['save','id' => $id]);

        return $this->render('form',  compact('sn','toUrl'));
    }

    public function actionSave($id = null){
        $post = Yii::$app->request->post();

        if ($id){
            $sn = SocialNetworks::findOne($id);
        } else {
            $sn = new SocialNetworks();
        }
        $sn->load($post);
        if (!$sn->save()){
            $errors = [];
            foreach ($sn->getErrors() as $key => $error){
                $errors['socialnetworks-'.$key] = $error;
            }
            return $this->sendJsonData([
                JsonData::SHOW_VALIDATION_ERRORS_INPUT => $errors,
            ]);
        }
        return $this->sendJsonData([
            JsonData::SUCCESSMESSAGE => "Успешно сохранено",
            JsonData::REFRESHPAGE => '',
        ]);
    }

    public function actionDelete($id){
        $sn = SocialNetworks::findOne($id);
        $sn->delete();
        return $this->sendJsonData([
            JsonData::SUCCESSMESSAGE => "Успешно удалено",
            JsonData::REFRESHPAGE => '',
        ]);
    }
}