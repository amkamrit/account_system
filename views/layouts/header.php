<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

?>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span> 
      </button>
      <a class="navbar-brand" href="<?= Yii::$app->request->baseUrl ?>"><?= strtoupper(Yii::$app->Info->getSoftwareName()) ?></a>
    </div>
  <?php  if (!Yii::$app->user->isGuest) {?>
    <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav navbar-right">
           <?php if(Yii::$app->Info->isSettingSet()){ ?>

                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Product Manage
                    <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?= Yii::$app->request->baseUrl.'/memberregister'?>">Member Register</a></li>
                      <li><a href="<?= Yii::$app->request->baseUrl.'/memberaccount'?>">Product Account</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl.'/site/memberinfo'?>">Member Account Info</a></li>
                    
                    
                  </ul>

                </li>

                <li><a href="<?= Yii::$app->request->baseUrl.'/site/index'?>">Dashboard</a></li>
                <li><a href="<?= Yii::$app->request->baseUrl.'/accounts'?>">Accounts</a></li>
                <li><a href="<?= Yii::$app->request->baseUrl.'/entries/'?>">Entries</a></li>
                <li class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" href="#">Reports
                  <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="<?= Yii::$app->request->baseUrl.'/reports/balance-sheet'?>">Balance Sheet</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl.'/reports/profit-and-loss'?>">Profit & Loss</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl.'/reports/trial-balance'?>">Trial Balance</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl.'/reports/entries'?>">Entries Report</a></li>
                  </ul>
                </li>
                  <li><a href="<?= Yii::$app->request->baseUrl.'/site/setting'?>">Setting</a></li>
            <?php } ?>
    
              <li> <?php
                               echo Html::a('Logout('.Yii::$app->user->identity->username.')', ['site/logout'], ['class' => 'login','data' => [
                      'confirm' => 'Are you sure you want to Logout?',
                      'method' => 'post',
                  ],]) ;
                  ?>
              </li>

            
          </ul>
      </div>
    <?php } else { ?>

    <?php  } ?>
  </div>
</nav>