<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Entries */


$this->title='JOURNAL ENTRY';
?>
<div class="entries-view">

  

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary hidden-print']) ?>
         <?= Html::a('Create New Journal Entry', ['create'], ['class' => 'btn btn-success']) ?>

        <a href="#" id="print" onClick="window.print()" class="btn btn-info pull-right hidden-print" style="margin-right: 10px">PRINT</a>
    </p>

  <span class="pull-left"><b>Voucher No:<?= $model->number ?></b></span>
  <span class="pull-right"><b>Date:<?= $model->date ?></b></span><br>
  <?php echo $this->render('../printHeader'); ?>


  <h4><b><center><?= $this->title ?></center></b></h4>
   <table class="table table-bordered">
        <th>Particular</th>
       <th>Lf No</th>
       <th>Cheque No</th>
       <th>Debit Amount(Rs)</th>
       <th>Credit Amount(Rs)</th>
       <?php foreach ($items as $key => $value) 
       {?>
        <tr>
            <td><?= $value->dc == "D" ? Yii::$app->Accounts->ledgerWithCode($value->ledger->code,$value->ledger->name) :"&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTo, ".   Yii::$app->Accounts->ledgerWithCode($value->ledger->code,$value->ledger->name) ?></td>
            <td><?= $value->ledger->id ?></td>
            <td><?= $value->cheque_no ?></td>
            <td><?= $value->dc == "D" ? $value->amount:'' ?></td>
            <td><?= $value->dc == "C" ? $value->amount:'' ?></td>
        </tr>

       <?php }
       ?>
        <tr>
            <td colspan=3><?= $model->narration ?></td>
            <td><?= $model->dr_total ?></td>
            <td><?= $model->cr_total ?></td>
        </tr>
        <tr>
            <td colspan=5><b>In Words:<?= Yii::$app->NumberToWord->numberToWords($model->dr_total); ?> only</b></td>
          
        </tr>
   </table>

   <div class="row">
    <div class="col-md-3 col-xs-3">Received By:.............</div>
    <div class="col-md-3 col-xs-3">Prepared By:.............</div>
    <div class="col-md-3 col-xs-3">Verified By:.............</div>
    <div class="col-md-3 col-xs-3">Approved By:.............</div>
   </div>
  


</div>
