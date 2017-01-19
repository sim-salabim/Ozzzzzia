<?php
namespace frontend\rules\url;

use yii;
use yii\web\UrlRuleInterface;
use yii\base\Object;
use yii\web\UrlRule;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

class LocationUrlRule extends UrlRule implements UrlRuleInterface
{

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();

        $result = parent::parseRequest($manager, $request);

        if ($result === false) {
            return false;
        }

        list($route, $params) = $result;

        $cityName = ArrayHelper::getValue($params, 'city', false);

        $city = \common\models\City::find()
                        ->byLocation()
                        ->whereDomain($cityName)
                        ->one();

        if (!$city) return false;

        Yii::$app->location->city = $city;

        return [$route,$params];
    }

}