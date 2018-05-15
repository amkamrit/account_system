<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Groups;
use yii\helpers\ArrayHelper

/* @var $this yii\web\View */
/* @var $model app\models\Ledgers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ledgers-form">

    <?php $form = ActiveForm::begin(); ?>

  <div class="form-group field-ledgers-group_id required">
        <label class="control-label" for="ledgers-group_id">Group</label>
                                  <select id="ledgers-group_id" class="form-control" name="Ledgers[group_id]">

                                    <?php
                                    foreach ($ledger_options as $row => $data) {
                                        if ($row < 0) 
                                        {
                                                $prow=abs($row);
                                                if($model->group_id == $prow)
                                                echo '<option value="' . $prow . '" selected>' . $data . '</option>';
                                                else
                                                echo '<option value="' . $prow . '">' . $data . '</option>';

                                            
                                        } else {
                                          
                                        }
                                    } ?>
                                   </select>
                                   <div class="help-block"></div>
    </div>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

   
    <?= $form->field($model, 'op_balance_dc')->dropDownList(array('D'=>'Dr','C'=>'Cr'),
                                                                [
                                                                                  
                                                                ]);
                                                                ?>
     <?= $form->field($model, 'op_balance')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'notes')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
