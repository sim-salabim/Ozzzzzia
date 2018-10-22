<hr>
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-12">
        <? $id = uniqid();?>
        <div id="<?= $id ?>" class="carousel slide"  data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <? if(count($ad->files)){ ?>
                    <? foreach($ad->files as $key => $image){ ?>
                        <div class="carousel-item <? if($key == 0){ ?> active<? } ?>">
                            <img class="d-block img-fluid" src="<?= $image->getImage(false)?>">
                        </div>
                    <? } ?>
                <? }else{ ?>
                    <div class="carousel-item active">
                        <img class="d-block img-fluid" src="<?= $ad->avatar(false)?>">
                    </div>
                <? } ?>
            </div>
            <a class="carousel-control-prev" href="#<?= $id ?>" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#<?= $id ?>" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 nonpadding-left-items-media">
        <? if(time() >= $ad->expiry_date){?>
            <p><?= __('Ad is inactive since')." ".$ad->getHumanDate(\common\models\Ads::DATE_TYPE_EXPIRATION).". ".__("All ads contacts are blocked.") ?></p>
        <? } ?>
        <div class="price-title">
            <?= $ad->price . " ". __('rub') ?>
        </div>
        <div >
            <button class="btn btn-success my-1 width-100 show-number-button">
                <? if(!$show_phone_number){?>
                    <?= __('Show phone number') ?><br/>
                    <?= cutText($ad->user->phone_number, 3, false)."-**-***-***" ?>
                <? }else if($show_phone_number AND $show_phone_number == 1){ ?>
                    <?= $ad->user->phone_number ?>
                <? } ?>
            </button>
        </div>
        <div class="w-100"></div>
        <div class="col-lg-12 col-sm-4 nonpadding-left-items">
            <?= $ad->user->first_name ?>
        </div>
        <div class="col-lg-12  col-sm-4 nonpadding-left-items">
            <?= $ad->user->city->region->_text->name ?>,
            <?= $ad->user->city->_text->name ?>
        </div>
        <div class="col-lg-12  col-sm-4 nonpadding-left-items">
            <?= date('h:i', $ad->created_at)." ".date('d/m/Y', $ad->created_at) ?>
        </div>
    </div>
    <div class="w-100"><hr></div>
    <div class="col-12">
        <?= $ad->text ?>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#<?= $id ?>').carousel()
        $('.show-number-button').bind('click', function(){
            window.location.href = window.location.href.split('?')[0] + '?show_phone_number=1';
        });
    });
</script>