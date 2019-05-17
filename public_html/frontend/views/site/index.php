<?php
use yii\helpers\Url;
?>

<div class="row site-index">
    <div class="w-100"><hr></div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 font-14">
            <a href="<?= Url::toRoute(["/"])?>"><?= Yii::$app->location->country->_text->name?></a> <span class="ads-amount-city"> <?= $country_amount['ads_amount'] ?></span>
        </div>
         <?php foreach ($cities as $key => $city) { ?>
             <div class="col-lg-2 col-md-3 col-sm-4 col-6 font-14">
                 <a href="<?= Url::toRoute(["/".$city->city->domain."/"])?>"><?= $city->_text->name?></a> <span class="ads-amount-city"> <?= $city->city->ads_amount ?: 0 ?></span>
             </div>
         <?php } ?>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 font-14">
            <a href="<?= Url::toRoute(["/vybor-goroda/"])?>"><?= __('_City') ?></a>
        </div>
    <div class="w-100"><hr></div>
    <? $div_row_unneeded = true; ?>
    <?= $this->render('/categories/list', compact('categories', 'div_row_unneeded'));?>

</div>
<?
$show_s_blocks = Yii::$app->location->country->id == 1 ? true : false;

?>
<?=  $this->render('/partials/_ads_list.php',
    [
        'padding_top_20' => true,
        'ads_search' => $ads_search,
        'library_search'=> $library_search,
        'title' => countString($ads_search['count'], [__('proposal'), __('proposals_im_p'), __('proposals_r_p') ]),
        'no_ads_title' => __('No ads found'),
        'show_sn_widgets' => $show_s_blocks,
//            'current_category' => $current_category,
//            'current_action' => $current_action
    ]) ?>
