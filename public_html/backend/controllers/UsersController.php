<?php

namespace backend\controllers;

use Yii;
use backend\controllers\BaseController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\helpers\JsonData;
use common\models\User;
use yii\helpers\Url;
use yii\base\Request;

class UsersController extends BaseController
{
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

    public function actionIndex()
    {
        $current_page = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;
        $limit = 20;
        $offset = ($current_page - 1) * $limit;
        $rows = User::find()->count();
        $pages_amount = ceil($rows/$limit);
        $users = User::find()
            ->limit($limit)
            ->offset($offset)
            ->with(['city','city.cityText'])->all();
//                    ->createCommand()->getRawSql();

        $toUrl = Url::toRoute('create');

        return $this->render('index',  compact('users','toUrl', 'pages_amount', 'current_page'));
    }

    public function actionCreate()
    {
        $user = new User;

        $toUrl = Url::toRoute('save');

        return $this->render('create',  compact('user','toUrl'));
    }

    public function actionUpdate($id)
    {
       $user = User::findOne($id);

        return $this->render('create',  compact('user'));
    }

    public function actionSave($id = null)
    {
        $user = ($id) ? User::findOne($id) : new User;

        $user->load(Yii::$app->request->post());

        $user->save();

        return $this->sendJsonData([
                JsonData::SUCCESSMESSAGE => "Пользователь \"$user->fullName}\" успешно сохранен",
                JsonData::REFRESHPAGE => '',
        ]);
    }

    public function actionGeneratePassword(){
        $bytes = openssl_random_pseudo_bytes(4);

        $password = bin2hex($bytes);

        return $this->sendJsonData([
                JsonData::GENERATEPASSWORD => $password,
        ]);
    }

}
