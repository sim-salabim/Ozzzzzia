<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;


class CitiesController extends Controller
{

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
    

    public function actionSearchCities(){
        
        $post = Yii::$app->request->post();
        $searchText = $post['search_text'];
        
        $cities = \common\models\City::find()
                        ->searchWithRegion($searchText)
                        ->byLocation();        
        
        if (isset($post['format']) && $post['format'] === 'json'){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            $cities->asArray();
        } 
        
        return $cities->all();
    }
}
