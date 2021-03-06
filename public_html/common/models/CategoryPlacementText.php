<?php

namespace common\models;

use Yii;
use common\models\Language;

/**
 * This is the model class for table "categories_text".
 *
 * @property integer $id
 * @property integer $category_placement_id
 * @property integer $languages_id
 * @property string $name
 * @property string $seo_h1
 * @property string $seo_h2
 * @property string $seo_title
 * @property string $seo_desc
 * @property string $seo_keywords
 * @property string $seo_text
 *
 * @property Language[] $languages
 * @property CategoryPlacement $categoryPlacement
 */
class CategoryPlacementText extends \yii\db\ActiveRecord
{
    const SCENARIO_DEFAULT = 'default';

    public function scenarios()
    {
        return [
            self::SCENARIO_DEFAULT => [
                'category_placement_id',
                'languages_id',
                'name',
                'seo_h1',
                'seo_h2',
                'seo_title',
                'seo_desc',
                'seo_keywords',
                'seo_text'
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories_placement_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_placement_id'], 'required'],
            [['category_placement_id', 'languages_id'], 'integer'],
            [['seo_title', 'seo_h1','seo_h2','name'], 'string', 'max' => 255],
            [['languages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['languages_id' => 'id']],
            [['category_placement_id'], 'exist', 'skipOnError' => true, 'targetClass' => CategoryPlacement::className(), 'targetAttribute' => ['category_placement_id' => 'id']],
            ['languages_id','default','value' => Language::getDefault()->id]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_placement_id' => 'Categories/Placement ID',
            'languages_id' => 'Languages ID',
            'seo_title' => 'Seo Title',
            'seo' => 'Name',
            'seo_h1' => 'Seo H1',
            'seo_h2' => 'Seo H2',
            'seo_desc' => 'Seo Desc',
            'seo_keywords' => 'Seo Keywords',
            'seo_text' => __('SEO text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'languages_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlacementCategories()
    {
        return $this->hasOne(CategoryPlacement::className(), ['id' => 'category_placement_id']);
    }
}
