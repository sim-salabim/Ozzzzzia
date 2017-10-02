<?php
namespace frontend\models;

use common\models\Ads;
use common\models\Placement;
use Yii;
use yii\base\Model;
use common\models\Mailer;
use common\models\Files;

/**
 * New Add form
 */
class NewAdForm extends Model
{
    public $categories_id;
    public $subcategory;
    public $subsubcategory;
    public $placement_id;
    public $expiry_date;
    public $cities_id;
    public $title;
    public $text;
    public $price;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'categories_id',
                'subcategory',
                'placement_id',
                'expiry_date',
                'title',
                'text',
                'price',
                'cities_id'], 'required', 'message' => __('Required field')],
            [[
                'categories_id',
                'subcategory',
                'placement_id',
                'expiry_date',
                'cities_id'], 'integer', 'integerOnly' => true, 'min' => 1],
            [['expiry_date','price'], 'integer', 'message' => __('Incorrect format')],
            ['subsubcategory', 'validateSubSubCategory']
        ];
    }

    public function newAd(){
        $adsModel = new Ads();
        $adsModel->created_at = time();
        $adsModel->categories_id = (!$this->subsubcategory) ? $this->subcategory : $this->subsubcategory;
        $adsModel->cities_id = $this->cities_id;
        $adsModel->users_id = \Yii::$app->user->identity->id;
        $adsModel->title = $this->title;
        $adsModel->text = $this->text;
        $adsModel->price = $this->price;
        $adsModel->expiry_date = time() + $this->expiry_date;
        $adsModel->placements_id = $this->placement_id;
        $adsModel->url = $adsModel->generateUniqueUrl($this->title);
        $adsModel->save();
        Files::linkFilesToModel($_POST['files'], $adsModel);
        Mailer::send(Yii::$app->user->identity->email, __('Add successfully added.'), 'add-published', ['user' => Yii::$app->user->identity, 'add' => $adsModel]);
    }
    /** Валидация субкатегории 3-го уровня
     *
     * @param $attribute
     * @param $params
     */
    public function validateSubSubCategory($attribute, $params){
        if ($this->subsubcategory !== null AND $this->subsubcategory < 1) {
            $this->addError($attribute, __('Required field'));
        }
    }

}
