<?php
namespace frontend\controllers;

use common\models\Ads;
use common\models\Category;
use common\models\CategoryPlacement;
use common\models\Language;
use common\models\libraries\AdsSearch;
use common\models\PlacementsText;
use Yii;
use yii\helpers\Url;


class CategoriesController extends BaseController
{
    /**
     * Текущая категория
     */
    protected $category = null;
    protected $placement = null;
    protected $canonical = null;
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

    public function actionIndex(){
        $categoryUrl = Yii::$app->request->get('category');
        $this->canonical = Url::home(true) . $categoryUrl . "/";
        $action = Yii::$app->request->get('placement');
        $sort = Yii::$app->request->get('sort');
        $direction = Yii::$app->request->get('direction');
        $action_id = null;
        if($action){
            $action_id = PlacementsText::findOne(['url' => $action])->placements_id;
            $this->canonical .= $action . '/';
        }
        if(Yii::$app->request->get('city')){
            $this->canonical .=  Yii::$app->request->get('city'). '/';
        }

        $category = Category::getByUrl($categoryUrl);

        $this->category = $category;

        $subCategories = $this->category->children;
        $categoryPlacements = $this->category->placements;

        if($action){
            $category_placement = CategoryPlacement::find()->where(['placements_id' => $action_id, 'categories_id' => $category->id])->one();
            $this->seo_title = $category_placement->_text->seo_title;
            $this->seo_h1 = $category_placement->_text->seo_h1;
            $this->seo_h2 = $category_placement->_text->seo_h2;
            $this->seo_text = $category_placement->_text->seo_text;
            $this->seo_desc = $category_placement->_text->seo_desc;
            $this->seo_keywords = $category_placement->_text->seo_keywords;
        }else{
            $this->seo_title = $category->_text->seo_title;
            $this->seo_h1 = $category->_text->seo_h1;
            $this->seo_h2 = $category->_text->seo_h2;
            $this->seo_text = $category->_text->seo_text;
            $this->seo_desc = $category->_text->seo_desc;
            $this->seo_keywords = $category->_text->seo_keywords;
        }
        $breadcrumbs = $this->category->getAllParentsForBreadcrumbs();
        Yii::$app->view->params['breadcrumbs'] = $this->setBreadcrumbs($breadcrumbs);
        $librarySearch = new AdsSearch();
        $librarySearch->setCategory($this->category->id);
        $librarySearch->setAction($action_id);
        $page = (Yii::$app->request->get('page')) ? Yii::$app->request->get('page') : $librarySearch->page;
        $librarySearch->setPage($page);
        if($sort AND $direction) {
            $librarySearch->setSorting($sort." ".$direction);
        }

        $ads_list = Ads::getList($librarySearch);
        $this->switchSeoKeys($ads_list);
        $this->setSeo($this->seo_h1, $this->seo_h2, $this->seo_text, $this->seo_desc, $this->seo_keywords, $this->canonical);
        $this->setPageTitle($this->seo_title);

        return $this->render('index',  [
            'current_category'      => $this->category,
            'categories'    => $subCategories,
            'row_list'      => true,
            'placements'    => $categoryPlacements,
            'current_action'=> $action,
            'page'          => $page,
            'ads_search'    => $ads_list,
            'library_search'=> $librarySearch
        ]);
    }

    public function actionGetSubCategories(){
        $subcats_json = '[';
        if (Yii::$app->request->isPost){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            $subcategories = Category::find()
                ->withText(['languages_id' => Language::getDefault()->id])
                ->where(['parent_id' => $post['category_id']])
                ->all();
            if(count($subcategories)) {
                foreach ($subcategories as $key => $subcat) {
                    $comma = (isset($subcategories[++$key])) ? ',' : '';
                    $has_chidren = (count($subcat->children)) ? '1' : '0';
                    $subcats_json .= '{"id":"'.$subcat->id.'","name":"'.$subcat->_text->name.'","has_children":'.$has_chidren.'}'.$comma;
                }
            }
        }
        $subcats_json .= ']';
        return $subcats_json;
    }

    public function actionGetCategoryPlacement(){
        $action_json = '[';
        if (Yii::$app->request->isPost){
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $post = Yii::$app->request->post();
            $category = Category::find()
                ->withText(['languages_id' => Language::getDefault()->id])
                ->where(['id' => $post['category_id']])
                ->one();
            if(count($category->placements) > 0){
                foreach($category->placements as $key => $action){
                    $comma = (isset($category->placements[++$key])) ? ',' : '';
                    $action_json .= '{"id":"'.$action->id.'","name":"'.$action->_text->name.'"}'.$comma;
                }
            }
        }
        $action_json .= ']';
        return $action_json;
    }
}