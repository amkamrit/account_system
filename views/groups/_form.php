<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Groups;
use yii\helpers\ArrayHelper

/* @var $this yii\web\View */
/* @var $model app\models\Groups */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="groups-form">

    <?php $form = ActiveForm::begin(); ?>

  <div class="form-group field-groups-parent_id required">
        <label class="control-label" for="groups-parent_id">Parent Group</label>
                                  <select id="groups-parent_id" class="form-control" name="Groups[parent_id]" aria-invalid="false">

                                    <?php
                                    foreach ($ledger_options as $row => $data) {
                                        if ($row < 0) 
                                        {
                                                $prow=abs($row);
                                                if($model->id == $prow)
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

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
