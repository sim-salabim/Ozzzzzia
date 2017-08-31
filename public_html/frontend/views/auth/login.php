<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>
<form class="form-horizontal" method="post" id="login-form">

<!-- Email-->
<div class="form-group validation-errors ">
  <label class="col-sm-2 control-label" for="email">Email</label>
  <div class="col-md-4">
    <input id="email" name="email" type="email" placeholder="email@mail.com" class="form-control input-md <?php if(Yii::$app->session->getFlash('email_error')){?> is-invalid<?php }?>" required="">
      <?php if(Yii::$app->session->getFlash('email_error')){?>
          <div class="invalid-feedback">
              <?= Yii::$app->session->getFlash('email_error') ?>
          </div>
      <?php } ?>
  </div>
</div>

<!-- Password-->
<div class="form-group validation-errors ">
  <label class="col-sm-2 control-label" for="password">Пароль</label>
  <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="Пароль" class="form-control input-md <?php if(Yii::$app->session->getFlash('password_error')){?> is-invalid<?php }?>" required="">
      <?php if(Yii::$app->session->getFlash('password_error')){?>
          <div class="invalid-feedback">
              <?= Yii::$app->session->getFlash('password_error') ?>
          </div>
      <?php } ?>
  </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <a href="/recovery">Забыли пароль?</a>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button class="btn btn-default senddata" data-input="#login-form">Войти</button>
    </div>
</div>

</form>

