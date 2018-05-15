<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



?>

<?= $this->render('search',['id'=>$ledger->id,'search'=>$search]); ?>
<?php echo $this->render('../printHeader'); ?>
<center><h4><b><?= $this->title; ?></b></h4></center>

<hr>

<div class="col-md-3"></div>
<div class="col-md-6">
<table class="table table-bordered" style="background:#e6f9ff">
<tr>
    <td>Ledger</td>
    <td><?= $ledger->name ?></td>
</tr>
<tr>
    <td>Notes</td>
    <td><?= $ledger->notes ?></td>
</tr>
<tr>
    <td>Opening Balance</td>
    <td> <?= Yii::$app->Accounts->convertDcPrefix($ledger->op_balance_dc,$ledger->op_balance); ?></td>
</tr>
<tr>
    <td>Closing Balance</td>
    <!-- Printing Closing Balance -->
    <td><?= Yii::$app->Accounts->convertDcPrefix(Yii::$app->Accounts->closingBalance($ledger->id,$search->start_date,$search->end_date)['cl_total_dc'],Yii::$app->Accounts->closingBalance($ledger->id,$search->start_date,$search->end_date)['cl_total']); ?></td>
</tr>

</table>
</div>

<div>
            <table class="table table-bordered">
                <thead>
                    <th>Date</th>
                    <th>Number</th>
                  
                    <th>Ledger</th>
                   <!--  <th>Type</th> -->
                    <!-- <th>Tag</th> -->
                    <th>Debit Amount(Rs)</th>
                    <th>Credit Amount(Rs)</th>
                    <th>Balance(Rs)</th>
                    <th>Result</th>
                </thead>
                <?php
                //Setting Opening Balance
                    $op_balance=0.00;
                    $op_balance_dc=null;
                    if($ledger->op_balance_dc == 'D')
                    {
                        $op_balance_dc='D';
                        $op_balance=$ledger->op_balance;
                    }
                    else if($ledger->op_balance_dc == 'C')
                    {
                        $op_balance_dc='C';
                        $op_balance=$ledger->op_balance;
                    }

                ?>
                <tr class="success">
                    <td colspan=6><b>Opening Balance</b></td>
                    <td><b>
                    <?=  Yii::$app->Accounts->convertDcPrefix($op_balance_dc,$op_balance); ?></b></td>
                    <td></td>
                </tr>
                <?php 
                 $data['balance_amount']=$op_balance;
                 $data['balance_amount_dc']=$op_balance_dc;
                foreach ($model as $key => $value) 
                {   
                    if($key == 0 && $op_balance_dc == null)
                    {   
                        $data['balance_amount']=$value->amount;
                        $data['balance_amount_dc']=$value->dc;
                    }
                    else
                    {
                        $data=$value->calculateBalanceAmount($data['balance_amount_dc'],$data['balance_amount']);  
                    }

                ?> 
                   <tr>
                        <td><?= $value->entry->date ?></td>
                        <td><?= $value->entry->number ?></td>
                        
                        <td><?= $value->entry->getLedgerFormat() ?></td>
                       <!--  <td><?= $value->entry->entrytype->name; ?></td> -->
                        <!-- <td><?= $value->entry->tag_id ?></td> -->
                        <td><?= $value->dc == 'D' ?$value->amount:'' ?></td>
                        <td><?= $value->dc == 'C' ?$value->amount:'' ?></td>
                        <td><?=  Yii::$app->Accounts->convertDcPrefix($data['balance_amount_dc'],$data['balance_amount']); ?></td>
                        <td><?= Html::a('View', ['/entries/view','id'=>$value->entry_id], ['class'=>'btn btn-primary hidden-print']); ?></td>


                   </tr>

                <?php }
                ?>
                <tr class="info">
                    <td colspan=6><b>Closing Balance</b></td>
                    <td><b><?= Yii::$app->Accounts->convertDcPrefix($data['balance_amount_dc'],$data['balance_amount']); ?></b></td>
                    <td></td>

                </tr>

            </table>
</div>
<hr>
