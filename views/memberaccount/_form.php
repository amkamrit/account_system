<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\memberregister;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberaccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="memberaccount-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Name')->dropDownList([
        'prompt'=>'Please select Cline Name',
ArrayHelper::map(memberregister::find()->all(),'Name','Name'),
    
    ])?>

    <?= $form->field($model, 'Product_Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Size')->textInput() ?>

    <?= $form->field($model, 'Weight')->textInput() ?>

    <?= $form->field($model, 'Price')->textInput() ?>

    <?= $form->field($model, 'Quantity')->textInput() ?>

    <?= $form->field($model, 'Dr_Amount')->textInput() ?>

    <?= $form->field($model, 'Cr_Amount')->textInput() ?>

    <?= $form->field($model, 'Note')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
