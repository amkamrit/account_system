<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Memberaccount */

$this->title = 'New Product Manage';
$this->params['breadcrumbs'][] = ['label' => 'Memberaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberaccount-create" style="width: 70%; padding-left: 100px; padding-top: 20px;">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
