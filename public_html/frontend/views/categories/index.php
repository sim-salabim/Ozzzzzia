<?php
?>
<div class="row">
    <div class="w-100">
        <hr>
    </div>
</div>
<?
$row_list = (isset($row_list)) ? $row_list : false;
$current_category = (isset($current_category))  ? $current_category : null;
?>
<?= $this->render('list', compact('categories', 'row_list', 'current_category'));?>
<?=  $this->render('/partials/_ads_list.php',
    [
        'ads_search' => $ads_search,
        'library_search'=> $library_search,
        'title' => countString($ads_search['count'], [__('proposal'), __('proposals_im_p'), __('proposals_r_p') ]),
        'no_ads_title' => __('No ads found'),
        'current_category' => $current_category,
        'current_action' => $current_action,
        'root_url' => $root_url,
        'page_pagination_title' => $page_pagination_title,
        'advertising_code_above_categories' => $advertising_code_above_categories,
        'advertising_code_below_categories' => $advertising_code_below_categories,
        'advertising_code_above_sorting_block' => $advertising_code_above_sorting_block,
        'advertising_code_below_sorting_block' => $advertising_code_below_sorting_block,
        'advertising_code_above_ads_block' => $advertising_code_above_ads_block,
        'advertising_code_middle_ads_block' => $advertising_code_middle_ads_block,
        'advertising_code_below_ads_block' => $advertising_code_below_ads_block,
    ]) ?>
