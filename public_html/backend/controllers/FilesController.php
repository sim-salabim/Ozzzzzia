<?php
namespace backend\controllers;

use common\models\Files;
use common\models\FilesExts;
use Yii;

class FilesController extends BaseController
{
    public $params;

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

    public function beforeAction($action)
    {
        if($action->id == 'upload'){
            return "upload";// не знаю почему, но аплоадер из админки работает по другому нежели на фронте, нужно вернуть здесь непустую строку чтоб все было ок
        }
        $this->enableCsrfValidation = false;
    }

    public function actionUpload(){
        $fileName = 'file';
        $uploadPath = Yii::$app->params['uploadPath'];

        if (isset($_FILES[$fileName])) {
            $file = \yii\web\UploadedFile::getInstanceByName($fileName);
            $user_id = (\Yii::$app->user->identity) ? \Yii::$app->user->identity->id : "no_user";
            $hashed_name = md5(time() + $user_id + uniqid(rand(), true));
            if ($file->saveAs($uploadPath . '/' . $hashed_name)) {
                $path = $_FILES['file']['name'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                make_thumb($uploadPath . '/' . $hashed_name, $uploadPath . '/' . $hashed_name.Files::THUMBNAIL, 150, $ext);
                $extObj = FilesExts::findOne(['ext' => $ext]);
                if(isset($extObj->id)) {
                    $file = new Files();
                    $file->name = str_replace(".".$ext, '', $path);
                    $file->hash = $hashed_name;
                    $file->files_exts_id = $extObj->id;
                    $file->users_id = (\Yii::$app->user->identity) ? \Yii::$app->user->identity->id : null;
                    $file->save();
                    echo \yii\helpers\Json::encode($file);
                }
            }
        }

        return false;
    }

    public function actionRemove(){
        if (Yii::$app->user->isGuest) {
            return false;
        }
        if (Yii::$app->request->isAjax){
            $post = Yii::$app->request->post();
            if(isset($post['id']) AND $post['id']){
                $file = Files::findOne(['id' => $post]);
                if($file->id){
                    $file->deleteFile();
                }
            }
        }
        return true;
    }
}