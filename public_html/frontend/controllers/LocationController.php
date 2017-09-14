<?php
namespace frontend\controllers;

use common\models\Region;
use common\models\City;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;


class LocationController extends BaseController
{
    /**
     * Текущая локация
     */
    protected $location = null;
    protected $location_domains = [
        'country' => null,
        'region'  => null,
        'city'    => null,
    ];
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


    public function actionVyborGoroda(){
        $regions = Region::find()->all();
        $this->setPageTitle(__('_Location'));
        Yii::$app->view->params['breadcrumbs'] = $this->setBreadcrumbs([['label' => __('_Location'), 'link' => Url::toRoute('vybor-goroda')]]);
        Yii::$app->view->params['h1'] = __('_Location');
        return $this->render('list',  [
            'regions'      => $regions,
        ]);
    }

    public function actionSelectLocation(){
        $domain = Yii::$app->request->get('domain');
        if($domain != 'reset') {
            $location = Region::find()->where(['domain' => $domain])->one();
            if (!$location) {
                $location = City::find()->where(['domain' => $domain])->one();
                $this->location_domains['city'] = $domain;
                $this->location_domains['region'] = $location->region->domain;
                $this->location_domains['country'] = $location->region->country->domain;
                Yii::$app->location->city = $location;
                Yii::$app->location->region = $location->region;
                Yii::$app->location->country = $location->region->country;
            }else{
                $this->location_domains['city'] = null;
                $this->location_domains['region'] = $location->domain;
                $this->location_domains['country'] = $location->country->domain;
                Yii::$app->location->region = $location;
                Yii::$app->location->country = $location->country;
            }
            if (!$location) {
                throw new HttpException(404, 'Not Found');
            }
            setcookie("country", $this->location_domains['country'], null, '/');
            setcookie("region", $this->location_domains['region'], null, '/');
            setcookie("city", $this->location_domains['city'], null, '/');
        }else{
            setcookie("country", $this->location_domains['country'], time() - 3600, '/');
            setcookie("region", $this->location_domains['region'], time() - 3600, '/');
            setcookie("city", $this->location_domains['city'], time() - 3600, '/');
        }
        return $this->redirect(Url::toRoute("vybor-goroda"));
    }
}