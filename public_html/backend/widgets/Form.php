<?php
namespace backend\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper as AH;
use yii\base\Widget;

class Form extends Widget {

    public $rows = [];

    public $saveUrl = '';

    const INPUT_TEXT = 'textInput';

    const INPUT_HIDDEN = 'inputHidden';

    const INPUT_AREA_TEXT = 'textAreaInput';

    CONST INPUT_TEXT_AREA_REACH = 'textAreaReachInput';

    const INPUT_CHECKBOX_INACTIVE = 'inputCheckboxInactive';

    const INPUT_CHECKBOX = 'inputCheckbox';

    const MULTISELECT = 'multiselect';

    const INPUT_TREE = 'inputTreeSelect';

    const INPUT_MEDIA = 'inputMedia';

    const INPUT_CSRF = 'inputCsrf';

    const SELECT = 'select';

    const SEARCH_AUTOCOMPLETE = 'searchAutocomplete';
    const SEARCH_AUTOCOMPLETE_MULTISELECT = 'searchAutocompleteMultiselect';

    public function getViewPath()
    {
        return \Yii::getAlias('@app/widgets/views/form');
    }

    public function init()
    {
        parent::init();
    }

    public function run(){
        $rows = $this->rows;
        $saveUrl = $this->saveUrl;

        foreach ($rows as &$item){

            $this->setPanelContent($item);
        }

        return $this->render('base',compact('rows','saveUrl'));
    }

    protected function setPanelContent(&$row){
        $panelForm = '';
        $row['panel-content'] = [];

        foreach ($row['attributes'] as $attribute) {

            $inputType = $attribute['type'];

            $panelForm .= $this->$inputType($attribute);
        }

        $row['panel-content'] = $panelForm;
    }

    protected function inputTreeSelect($attribute){
        return $this->render('input-tree-select', compact('attribute'));
    }

    protected function inputCsrf($attribute){
        return $this->render('input-csrf', compact('attribute'));
    }

    protected function searchAutocomplete($attribute){
        return $this->render('search-autocomplete', compact('attribute'));
    }

    protected function searchAutocompleteMultiselect($attribute){
        return $this->render('search-autocomplete-multiselect', compact('attribute'));
    }

    protected function textInput($attribute){

        return $this->render('text-input', compact('attribute'));
    }

    protected function inputCheckbox($attribute){
        return $this->render('input-checkbox', compact('attribute'));
    }

    protected function inputMedia($attribute){
        return $this->render('input-media', compact('attribute'));
    }

    protected function textAreaInput($attribute){

        return $this->render('text-area-input', compact('attribute'));
    }

    protected function textAreaReachInput($attribute){

        return $this->render('text-area-reach-input', compact('attribute'));
    }

    protected function inputCheckboxInactive($attribute){

        return $this->render('input-checkbox-inactive', compact('attribute'));
    }

    protected function select($attribute){
        return $this->render('input-select', compact('attribute'));
    }

    protected function multiselect($attribute){
        $selectpicker = $attribute['selectpicker'];
        $values     = $selectpicker['values'];
        $selected   = $selectpicker['selected'];
        $options    = AH::getValue($selectpicker,'options',[]);
        $model      = $attribute['model'];
        $label      = $attribute['label'];
        $name       = $attribute['name'];

        return $this->render('multi-select',compact(
                'model',
                'values',
                'selected',
                'options',
                'label',
                'name'
        ));
    }
}