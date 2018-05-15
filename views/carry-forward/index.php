<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\CarryForward;
use yii\web\View;

$this->title='CARRY FORWARD YOUR ACCOUNT';
?>

 <center><h1><b><?= Html::encode($this->title) ?></b></h1>
<h4><b><u>NOTE: While Carrying Forward, Adjust P/L Account Balance for Next Year Yourself.</u></b></h4></center>
<hr><br><br>

<div style="margin:10px;">
		
		<div id="carry_forward" class="panel">
		    <?php $form = ActiveForm::begin(['action' => ['carry-forward/carry-account-to-next-year']]); ?>
		    
		    <?= $form->field(new CarryForward(), 'fy_start')->widget(MaskedInput::className(), [
                                                'mask' => '9999-99-99',
                                            ]) 
    		?>
    		<?= $form->field(new CarryForward(), 'fy_end')->widget(MaskedInput::className(), [
                                                'mask' => '9999-99-99',
                                            ]) 
    		?>
    		<hr>
		    <?= $form->field(new CarryForward(), 'host'); ?>
		    <?= $form->field(new CarryForward(), 'database_name')->label('Database Name (Prefix: '.Yii::$app->Info->getClientCode().'_)'); ?>
		    <?= $form->field(new CarryForward(), 'database_username'); ?>
		    <?= $form->field(new CarryForward(), 'database_password'); ?>

		    
		  <div class="form-group">
		        <?= Html::submitButton('Carry Forward', ['class' => 'btn btn-success','id'=>'final-submit']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>

		</div>
</div>





