<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use app\models\Tags;
use app\models\Entrytypes;
use app\models\Ledgers;
/* @var $this yii\web\View */
/* @var $model app\models\Entries */
/* @var $form yii\widgets\ActiveForm */
$this->title="Update Entry ".$model->number;
?>

 <h2><center><b><?= strtoupper($this->title) ?></b></center></h2> <hr>
<div class="entries-form" ng-app="App" ng-controller="entryformcontroller">

    <?php $form = ActiveForm::begin(['options'=>['style'=>'margin-left: -40px']]); ?>


  
    <?= $form->field($model, 'date')->widget(MaskedInput::className(), [
                                                'mask' => '9999-99-99',
                                            ]) 
    ?>
   <table class="table table-bordered">
    <thead>
          <tr>
                        <th>Dr/Cr</th>
                        <th>Ledger</th>
                        <th>Dr. Amount</th>
                        <th>Cr. Amount</th>
                        <th>Cheque No</th>
                        <th>Actions</th>
                        <th>Current Balance</th>
          </tr>
    </thead>

    <tbody>
        
            <?php foreach ($items as $key => $value) { ?>
             <tr>
                            <td>
                               <?= $form->field($items[$key], '['.$key.']dc')->label(false)->dropDownList(array('D'=>'Dr','C'=>'Cr'),
                                                                [
                                                                    
                                                                    'class'=>'dc-dropdown'                         
                                                                ]);
                            ?>
                            </td>
                            <td>
                             <div class="form-group field-entryitems-<?= $key ?>-ledger_id">
                                  <select id="entryitems-<?= $key ?>-ledger_id" class="ledger-dropdown" name="Entryitems[<?= $key ?>][ledger_id]" aria-invalid="false">

                                    <?php
                                    foreach ($ledger_options as $row => $data) {
                                        if ($row >= 0) 
                                        {
                                            if($row == 0)
                                            {
                                                 //echo '<option value="">' . $data . '</option>';    
                                            }
                                            else
                                            {
                                                if($value->ledger_id == $row)
                                                echo '<option value="' . $row . '" selected>' . $data . '</option>';
                                                else
                                                echo '<option value="' . $row . '">' . $data . '</option>';

                                            }
                                        } else {
                                            echo '<option value="' . $row . '" disabled="disabled" class="bg-danger">' . $data . '</option>';
                                        }
                                    } ?>
                                   </select>
                                   <div class="help-block"></div>
                                </div>
                            
                            </td>
                            <td> 
                                <?= $form->field($items[$key], '['.$key.']dr_amount')->label(false)->textInput(['maxlength' => true,'class'=>'dr-amount']) ?>
                            </td>
                            <td>
                                <?= $form->field($items[$key], '['.$key.']cr_amount')->label(false)->textInput(['maxlength' => true,'class'=>'cr-amount']) ?>
                            </td>
                            <td>
                                    <?= $form->field($items[$key], '['.$key.']cheque_no')->label(false)->textInput(['maxlength' => true,'class'=>'cheque_no']) ?>

                            </td>
                            <td>

                               
                               
                            </td>
                            <td>
                            </td>
                </tr>
            <?php } ?>
              <tr>
                <td>TOTAL:</td>
                <td></td>
                <td id="dr-total"></td>
                <td id="cr-total"></td>
              </tr>

               <tr id="difference">
                <td>DIFFERENCE:</td>
                <td></td>
                <td id="dr-diff"></td>
                <td id="cr-diff"></td>
              </tr>
    </tbody>
</table>


 <?= $form->field($model, 'narration')->textArea(['maxlength' => true,'rows'=>4]) ?>
 <?= $form->field($model, 'tag_id')->dropDownList(ArrayHelper::map(Tags::find()->orderBy('title')->all(), 'id', 'title'),
                                                                [
                                                                    'prompt' => 'Select Tag',  
                                                                ]);
                            ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success','id'=>'final-submit']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
echo $this->registerJsFile('@web/web/js/angular.min.js');
echo $this->registerJsFile('@web/web/js/entryform.js');
echo $this->registerCssFile('@web/web/css/select2.css');
?>

<script language="javascript" type="text/javascript" src='<?= Yii::$app->request->baseUrl.'/web/js/jquery.js' ?>'></script>
<script src='<?= Yii::$app->request->baseUrl.'/web/js/select2.min.js' ?>'></script>
<script type="text/javascript">
$(".ledger-dropdown").select2({
         width: "300px"
    });
$(document).ready(function () {

    /* Add ledger row */
    $(document).on('click', '#add-row', function(event) 
    {
        event.preventDefault();   
    });


    /* Dr - Cr dropdown changed */
    $(document).on('change', '.dc-dropdown', function() {
       
        if ($(this).parent().parent().next().children().children().val() == '') {
            return;
        }
        if ($(this).prop('value') == "D") {
            $(this).parent().parent().next().next().next().children().children().prop('value', "");
            $(this).parent().parent().next().next().next().children().children().prop('disabled', 'disabled');
            $(this).parent().parent().next().next().children().children().prop('disabled', '');
        } else {
            
            $(this).parent().parent().next().next().children().children().prop('value', "");
            $(this).parent().parent().next().next().children().children().prop('disabled', 'disabled');
            $(this).parent().parent().next().next().next().children().children().prop('disabled', '');
        }
       
    });


    /* Ledger dropdown changed */
    $(document).on('change', '.ledger-dropdown', function() {
        if ($(this).val() == '') {
            /* Reset and diable dr and cr amount */
            $(this).parent().parent().next().children().children().prop('value', "");
            $(this).parent().parent().next().next().children().children().prop('value', "");
            $(this).parent().parent().next().children().children().prop('disabled', 'disabled');
            $(this).parent().parent().next().next().children().children().prop('disabled', 'disabled');
        } else {
            /* Enable dr and cr amount and trigger Dr/Cr change */
            $(this).parent().parent().next().children().children().prop('disabled', '');
            $(this).parent().parent().next().next().children().children().prop('disabled', '');
            $(this).parent().parent().prev().children().children().trigger('change');

            var thisRow=$(this);
            var ledger_id=$(this).val();
            //Setting CL Balance
            $.ajax({
                url: '<?php echo Yii::$app->request->baseUrl.'/ledgers/closingbalance' ?>',
                data: 'id=' + ledger_id,
                dataType: 'json',
                success: function(data)
                {
                     thisRow.parent().parent().next().next().next().next().next().html(data);
                }
            });
        }
        /* Trigger dr and cr change */
       
        $(".cr-amount").trigger('change');
        $(".dr-amount").trigger('change');
       
    });


      
    $(document).on('change', '.dr-amount', function() {
        var drTotal = 0;
        $("table tr .dr-amount").each(function() {
            var curDr = $(this).prop('value')
            curDr = parseFloat(curDr);
            if (isNaN(curDr))
                curDr = 0;
            drTotal += curDr;
        });
        $("table tr #dr-total").text(drTotal);
        var crTotal = 0;
        $("table tr .cr-amount").each(function() {
            var curCr = $(this).prop('value')
            curCr = parseFloat(curCr);
            if (isNaN(curCr))
                curCr = 0;
            crTotal += curCr    ;
        });
        $("table tr #cr-total").text(crTotal);

        if(crTotal != drTotal || crTotal == 0)
        {
            $("table #difference").css("background-color", "#FBEFEF");
             $("#final-submit").prop('disabled','disabled');
        }
        else
        {
            $("table #difference").css("background-color", "white");
            $("#final-submit").prop('disabled','');
        }

        $difference=crTotal - drTotal;
         if($difference < 0)
        {        
            $("table tr #dr-diff").text('');
            $("table tr #cr-diff").text(Math.abs($difference));

        }
         else if($difference > 0)
        {
            $("table tr #cr-diff").text('');
            $("table tr #dr-diff").text(Math.abs($difference));
        }
        else
        {
            $("table tr #cr-diff").text('');
            $("table tr #dr-diff").text('');
        }

    });

      $(document).on('change', '.cr-amount', function() {

        var drTotal = 0;
        $("table tr .dr-amount").each(function() {
            var curDr = $(this).prop('value')
            curDr = parseFloat(curDr);
            if (isNaN(curDr))
                curDr = 0;
            drTotal += curDr;
        });
        $("table tr #dr-total").text(drTotal);
        var crTotal = 0;
        $("table tr .cr-amount").each(function() {
            var curCr = $(this).prop('value')
            curCr = parseFloat(curCr);
            if (isNaN(curCr))
                curCr = 0;
            crTotal += curCr;
        });
        $("table tr #cr-total").text(crTotal);
        if(crTotal != drTotal || crTotal == 0)
        {
            $("table #difference").css("background-color", "#FBEFEF");
            $("#final-submit").prop('disabled','disabled');
        }
        else
        {
            $("table #difference").css("background-color", "white");
             $("#final-submit").prop('disabled','');
        }
         $difference=crTotal - drTotal;
        if($difference < 0)
        {        
            $("table tr #dr-diff").text('');
            $("table tr #cr-diff").text(Math.abs($difference));
        }
        else if($difference > 0)
        {
            $("table tr #cr-diff").text('');
             $("table tr #dr-diff").text(Math.abs($difference));
        }
         else
        {
            $("table tr #cr-diff").text('');
            $("table tr #dr-diff").text('');
        }
       

    });



$('.ledger-dropdown').trigger('change');
 $(".cr-amount").trigger('change');

});
</script>
