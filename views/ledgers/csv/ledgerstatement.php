<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



?>

<?= $this->title."\n"; ?>

    <?php
             //Summary tABLE
                   

                    echo '"';
                    echo 'LEDGER';
                    echo '",';

                    echo '"';
                    echo $ledger->name;
                    echo '",';
                    echo "\n";


                    echo '"';
                    echo 'NOTES';
                    echo '",';

                    echo '"';
                    echo $ledger->notes;
                    echo '",';
                    echo "\n";


                    echo '"';
                    echo 'OPENING BALANCE';
                    echo '",';

                    echo '"';
                    echo Yii::$app->Accounts->convertDcPrefix($ledger->op_balance_dc,$ledger->op_balance);
                    echo '",';
                    echo "\n";

                     echo '"';
                    echo 'CLOSING BALANCE';
                    echo '",';

                    echo '"';
                    echo Yii::$app->Accounts->convertDcPrefix(Yii::$app->Accounts->closingBalance($ledger->id,$search->start_date,$search->end_date)['cl_total_dc'],Yii::$app->Accounts->closingBalance($ledger->id,$search->start_date,$search->end_date)['cl_total']);
                    echo '",';
                    echo "\n";
                    echo "\n";
                    echo "\n";
                    echo "\n";

    ?>

                "Date","Number","Ledger","Type","Debit Amount(Rs)","Credit Amount(Rs)","Balance(Rs)","Result",
                <?= "\n" ?>
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
               
                <?php  
                
                    echo '"';
                    echo 'Opening Balance';
                    echo '",';

                    echo ',';
                    echo ',';
                    echo ',';
                    echo ',';
                    echo ',';
                    echo ',';

                    echo '"';
                    echo Yii::$app->Accounts->convertDcPrefix($op_balance_dc,$op_balance);
                    echo '",';
                   ?>
                   
                <?php echo "\n"; ?>

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

                        echo '"'.$value->entry->date.'",';
                        echo '"'.$value->entry->number.'",';
                        echo '"'.$value->entry->getLedgerFormatCsv().'",'; 
                        echo '"'.$value->entry->entrytype->name.'",';
                        echo '"';
                        echo $value->dc == 'D' ?$value->amount:'';
                        echo '",';

                        echo '"';
                        echo $value->dc == 'C' ?$value->amount:'';
                        echo '",';
                        echo '"'.$data['balance_amount_dc'] == 'D' ? 'Dr' : 'Cr';
                        echo $data['balance_amount'].'",';
                        echo "\n";

                    }
                    ?>
                 <?php  
                
                    echo '"';
                    echo 'Closing Balance';
                    echo '",';

                    echo ',';
                    echo ',';
                    echo ',';
                    echo ',';
                    echo ',';
                    echo ',';

                    echo '"';
                    echo Yii::$app->Accounts->convertDcPrefix($data['balance_amount_dc'],$data['balance_amount']);
                   echo '",';
                   
                   
                  
   

