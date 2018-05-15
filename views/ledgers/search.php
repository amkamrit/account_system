<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\DateSearch;
use yii\web\View;

?>

<div style="margin:10px;">
		<button id="toggleSearch" class="btn btn-info hidden-print">EXPAND SEARCH</button>
		<?= Html::a('EXPORT TO CSV', Yii::$app->request->baseUrl.'/ledgers/ledgerstatement?id='.$id.'&export=csv', ['class'=>'btn btn-info pull-right hidden-print','data-method' => 'POST','data-params' => [
    							'DateSearch[start_date]'=>$search->start_date != null ? $search->start_date :NULL,
    							'DateSearch[end_date]'=>$search->end_date != null ? $search->end_date :NULL

							],]) ?>
		<a href="#" id="print" onClick="window.print()" class="btn btn-info pull-right hidden-print" style="margin-right: 10px">PRINT</a>

		<div id="search_form" class="panel">
		    <?php $form = ActiveForm::begin(); ?>

		    <?= $form->field(new DateSearch(), 'start_date')->widget(MaskedInput::className(), [
		                                                'mask' => '9999-99-99',
		                                            ]) 
		    ?>
		    <?= $form->field(new DateSearch(), 'end_date')->widget(MaskedInput::className(), [
		                                                'mask' => '9999-99-99',
		                                            ]) 
		    ?>
		  <div class="form-group">
		        <?= Html::submitButton('Search', ['class' => 'btn btn-success','id'=>'final-submit']) ?>
		    </div>

		    <?php ActiveForm::end(); ?>

		</div>
</div>


<?php
echo $this->registerJsFile('@web/web/js/jquery.js');
echo $this->registerJsFile('@web/web/js/date_search.js');
?>



