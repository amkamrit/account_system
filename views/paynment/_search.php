<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PaynmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paynment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>
    <?= $form->field($model, 'Name') ?>

    <?= $form->field($model, 'Payment_Method') ?>

    <?= $form->field($model, 'Amount') ?>

    <?= $form->field($model, 'Cheque_Number') ?>

    <?= $form->field($model, 'Image') ?>

    <?php // echo $form->field($model, 'Note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
