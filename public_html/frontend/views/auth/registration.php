<?php
use kartik\select2\Select2;
use common\models\City;
$url = \yii\helpers\Url::toRoute('cities/search-cities-for-select');
$selectCity = __('Select a city');
$this->title = $cms->_text->seo_title;
$model = Yii::$app->session->getFlash('model');
$city_name = ($model AND $model->cities_id) ? City::findOne(['id' => $model->cities_id])->_text->name : '';
?>
<?
$advertising_code = \common\models\Advertising::getCodeByPlacement(\common\models\Advertising::PLACEMENT_TECHNICAL_PAGES_ABOVE_TEXT);
?>
<? if($advertising_code ){ ?>
    <div class="col-lg-12 padding-left0 padding-bottom-10">
        <?= $advertising_code; ?>
    </div>
<? } ?>
<form class="form-horizontal" method="post" id="registr-form">
    <input id="form-token" type="hidden" name="<?=Yii::$app->request->csrfParam?>"
           value="<?=Yii::$app->request->csrfToken?>"/>
    <?php  if(Yii::$app->session->getFlash('message')){ ?>
        <div class="alert alert-success" role="alert">
            <?= Yii::$app->session->getFlash('message'); ?>
        </div>
    <?php  } ?>
    <!-- Имя-->
    <div class="form-group validation-errors">

        <div class="form-group">
            <input
                id="first_name"
                name="first_name"
                type="text"
                <? if(isset($model) AND $model->first_name){?>
                    value="<?= $model->first_name ?>"
                <? }?>
                placeholder="<?= __('Name') ?>"
                class="form-control input-md <?php if(Yii::$app->session->getFlash('first_name_error')){?> is-invalid<?php }?>">
            <?php if(Yii::$app->session->getFlash('first_name_error')){?>
                <div class="invalid-feedback">
                    <?= Yii::$app->session->getFlash('first_name_error') ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Фамилия-->
    <div class="form-group validation-errors">
        <div class="form-group">
            <input
                id="last_name"
                name="last_name"
                type="text"
                <? if(isset($model) AND $model->last_name){?>
                    value="<?= $model->last_name?>"
                <? }?>
                placeholder="<?= __('Surname') ?>"
                class="form-control input-md <?php if(Yii::$app->session->getFlash('last_name_error')){?> is-invalid<?php }?>">
            <?php if(Yii::$app->session->getFlash('last_name_error')){?>
                <div class="invalid-feedback">
                    <?= Yii::$app->session->getFlash('last_name_error') ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Город-->
    <div class="form-group validation-errors">

        <div class="form-group">
            <input
                class="form-control bs-autocomplete <?php if(Yii::$app->session->getFlash('cities_id_error')){?> is-invalid<?php }?>"
                id="live-search-select"
                value="<?= $city_name ?>"
                placeholder="<?= $selectCity ?>"
                type="text"
                data-hidden_field_id="hidden-city"
                data-item_id="live-search-select"
                data-item_label="text"
                autocomplete="off">
            <?php if(Yii::$app->session->getFlash('cities_id_error')){?>
                <div class="invalid-feedback">
                    <?= Yii::$app->session->getFlash('cities_id_error') ?>
                </div>
            <?php } ?>
            <input type="hidden" id="hidden-city" name="cities_id" <? if(isset($model) AND $model->cities_id){?>
            value="<?= $model->cities_id ?>"
            <? }else{?> value=""<? } ?>>
        </div>
    </div>
    <!--  Номер телефона  -->
    <div class="form-group validation-errors">

        <div class="form-group">
            <input
                id="phone_number"
                name="phone_number"
                type="text"
                <? if(isset($model) AND $model->phone_number){?>
                    value="<?= $model->phone_number?>"
                <? }?>
                placeholder="<?= __('Phone Number') ?>"
                class="form-control input-md <?php if(Yii::$app->session->getFlash('phone_number_error')){?> is-invalid<?php }?>">
            <?php if(Yii::$app->session->getFlash('phone_number_error')){?>
                <div class="invalid-feedback">
                    <?= Yii::$app->session->getFlash('phone_number_error') ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Email-->
    <div class="form-group validation-errors">
        <div class="form-group">
            <input id="email"
                   name="email"
                   type="email"
                    <? if(isset($model) AND $model->email){?>
                        value="<?= $model->email?>"
                    <? }?>
                   placeholder="email@mail.com"
                   class="form-control input-md <?php if(Yii::$app->session->getFlash('email_error')){?> is-invalid<?php }?>">
            <?php if(Yii::$app->session->getFlash('email_error')){?>
                <div class="invalid-feedback">
                    <?= Yii::$app->session->getFlash('email_error') ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Password-->
    <div class="form-group validation-errors">

        <div class="form-group">
            <input
                id="password"
                name="password"
                type="password"
                placeholder="<?= __('Password') ?>"
                class="form-control input-md <?php if(Yii::$app->session->getFlash('password_error')){?> is-invalid<?php }?>">
            <?php if(Yii::$app->session->getFlash('password_error')){?>
                <div class="invalid-feedback">
                    <?= Yii::$app->session->getFlash('password_error') ?>
                </div>
            <?php } ?>


        </div>
    </div>
    <!-- I agree-->
    <div class="form-group validation-errors">
        <label>
            <input
                id="agreement"
                name="agreement"
                type="checkbox"
                checked
                class=" <?php if(Yii::$app->session->getFlash('agreement_error')){?> is-invalid<?php }?>"> <?= __('Signing up you\'re accepting') ?> <a  href="/polzovatelskoe-soglashenie/"><?= __('User agreement')?></a> <?= __('and agree with') ?> <a  href="/policy/"><?= __('Privacy policy') ?></a>.</label>
    </div>
    <?php if(Yii::$app->session->getFlash('agreement_error')){?>
        <div class="invalid-feedback dispaly-block">
            <?= Yii::$app->session->getFlash('agreement_error') ?>
        </div>
    <?php } ?>
    <div class="form-group">
        <a
           href="<?= yii\helpers\Url::toRoute('/login') ?>"
           style="margin-right: 20px;">
            <?= __('Login') ?>
        </a>

        <a href="<?= yii\helpers\Url::toRoute('/recovery') ?>"><?= __('Forgot your password?') ?></a>
    </div>

    <button class="btn btn-success senddata" data-input="#registr-form"><?= __('Sign up') ?></button>




</form>
<?
$advertising_code = \common\models\Advertising::getCodeByPlacement(\common\models\Advertising::PLACEMENT_TECHNICAL_PAGES_BELOW_TEXT);
?>
<? if($advertising_code ){ ?>
    <div class="col-lg-12 padding-left0 padding-top-10">
        <?= $advertising_code; ?>
    </div>
<? } ?>
<script type="text/javascript">
    $.widget("ui.autocomplete", $.ui.autocomplete, {

        _renderMenu: function(ul, items) {
            var that = this;
            ul.attr("class", "nav nav-pills nav-stacked  bs-autocomplete-menu list-group");
            $.each(items, function(index, item) {
                that._renderItemData(ul, item);
            });
        },

        _resizeMenu: function() {
            var ul = this.menu.element;
            ul.outerWidth(Math.min(
                ul.width("").outerWidth() + 1,
                this.element.outerWidth()
            ));
        }

    });

    (function() {
        $('.bs-autocomplete').each(function() {
            var _this = $(this),
                _data = _this.data(),
                _search_data = [],
                _visible_field = $('#' + _data.item_id),
                _hidden_field = $('#' + _data.hidden_field_id);


            _this.after('<div class="bs-autocomplete-feedback form-control-feedback"><div class="loader"><?= __('Search...') ?></div></div>')
                .parent('.form-group').addClass('has-feedback');

            var feedback_icon = _this.next('.bs-autocomplete-feedback');
            feedback_icon.hide();

            _this.autocomplete({
                minLength: 3,
                autoFocus: true,

                source: function(request, response) {
                    _hidden_field.val('');
                    $.ajax({
                        dataType: "json",
                        type : 'POST',
                        url: '<?= $url ?>',
                        data: {q: $('input#live-search-select').val()},
                        success: function(data) {
                            _search_data = data
                            $('input.suggest-user').removeClass('ui-autocomplete-loading');
                            if(_search_data.length == 0){
                                _hidden_field.val('');
                            }
                            response(data);
                        }
                    });
                },

                search: function() {
                    feedback_icon.show();
                    _hidden_field.val('');
                },

                response: function() {
                    feedback_icon.hide();
                },

                focus: function(event, ui) {
                    _this.val(ui.item[_data.item_label]);
                    event.preventDefault();
                },

                select: function(event, ui) {
                    _hidden_field.val(ui.item.id);
                    _this.val(ui.item[_data.item_label]);
                    _hidden_field.val(ui.item.id);
                    event.preventDefault();
                },
                close: function( event, ui ) {
                    if(_search_data.length != 0){
                        _hidden_field.val(_search_data[_visible_field.val()].id);
                    }
                }
            })
                .data('ui-autocomplete')._renderItem = function(ul, item) {
                return $('<li class="list-group-item" ></li>')
                    .data("item.autocomplete", item)
                    .append('<a>' + item[_data.item_label] + '</a>')
                    .appendTo(ul);
            };
        });
    })();
</script>