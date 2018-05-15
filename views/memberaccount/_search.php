<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MemberaccountSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="memberaccount-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Sn') ?>

    <?= $form->field($model, 'Name') ?>

    <?= $form->field($model, 'Product_Name') ?>

    <?= $form->field($model, 'Size') ?>

    <?= $form->field($model, 'Weight') ?>

    <?php // echo $form->field($model, 'Price') ?>

    <?php // echo $form->field($model, 'Quantity') ?>

    <?php // echo $form->field($model, 'Dr_Amount') ?>

    <?php // echo $form->field($model, 'Cr_Amount') ?>

    <?php // echo $form->field($model, 'Note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
