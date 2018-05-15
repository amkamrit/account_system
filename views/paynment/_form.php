<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\memberregister

/* @var $this yii\web\View */
/* @var $model backend\models\Paynment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paynment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Name')->dropDownList([
        'prompt'=>'Please select Cline Name',
    ArrayHelper::map(memberregister::find()->all(),'Name','Name'),
    
    ])?>

    <?= $form->field($model, 'Payment_Method')->dropDownList([
        'Select Payment Method',
        'By Bank',
        'By Cheque',
        'By Cash',
        ]) ?>

    <?= $form->field($model, 'Amount')->textInput() ?>

    <?= $form->field($model, 'Cheque_Number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Note')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
