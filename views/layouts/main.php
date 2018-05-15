<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\widgets\Alert;
use app\myassets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

  <?= $this->render('header'); ?>

 <span class="pull-right hidden-print" style="margin-right:30px">
  <?php 
        if(Yii::$app->Info->isSettingSet())
        echo '<b>FINANCIAL YEAR : '.Yii::$app->Info->getClientFyStart().' to '.Yii::$app->Info->getClientFyEnd() .'</b>';
?>
 </span>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
          <?php
            if(Yii::$app->session->hasFlash("success"))
            {?>
                    <span class="alert alert-success col-md-12"><?= Yii::$app->session->getFlash("success") ?></span>
            <?php } 
            if(Yii::$app->session->hasFlash("error"))
            {?>
                    <span class="alert alert-danger col-md-12"><?= Yii::$app->session->getFlash("error") ?></span>
            <?php } ?>


        <?= $content ?>
    </div>
</div>

<footer class="footer hidden-print">
    <div class="container">
        <p class="pull-left">&copy;  <?= Yii::$app->Info->getDeveloperCompany().' '.date('Y') ?></p>

        <p class="pull-right">
            <?php 
                if(Yii::$app->Info->isSettingSet())
                echo Yii::$app->Info->getClientName(); 
            ?>
        </p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<script>
    /** 
    Wait for window load
    Used for loading screen until page loads.
    **/
    $(window).load(function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
</script>

<!-- 
    Css for hiding a href Url during print
-->
<style>
@media print {
    a:after { content:''; }
    a[href]:after { content: none !important; }

}
</style>