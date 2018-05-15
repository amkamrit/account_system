<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */
/* @var $form yii\widgets\ActiveForm */
?>

<h2><center><b><?= strtoupper($this->title) ?></b></center></h2> <hr>
<div class="settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

   
     <?= $form->field($model, 'fy_start')->widget(MaskedInput::className(), [
                                                'mask' => '9999-99-99',
                                            ]) 
    ?>

    <?= $form->field($model, 'fy_end')->widget(MaskedInput::className(), [
                                                'mask' => '9999-99-99',
                                            ]) 
    ?>
    <?= $form->field($model, 'description')->textArea(['rows' => 8]) ?>
    <div class="form-group">
        <?= Html::submitButton('CREATE NEW ACCOUNT', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
