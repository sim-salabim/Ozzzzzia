<?php
namespace common\models\scopes;

use yii\db\ActiveQuery;

class CountryQuery extends ActiveQuery {

    use \common\models\scopes\traits\Text;

    const TEXT_RELATION = 'countryText';
    const TEXT_RELATION_TABLE = 'countries_text';

    public function current(){
        return $this->andWhere(['domain' => \Yii::$app->params['mainDomain']]);
    }

//    public function withText($languages_id = null){
//        return $this->with(['countryText' => function($query) use ($languages_id){
//            $tableName = \common\models\CountryText::tableName();
//
//            if ($languages_id){
//                return $query->andWhere(["$tableName.languages_id" => $languages_id]);
//            }
//        }]);
//    }

}