
<?php
use yii\helpers\Html;

function print_account_chart($account, $c = 0, $THIS)
{

		$counter = $c;
		if($account->id != 0)
		{
			echo '"';
			echo Yii::$app->Accounts->ledgerWithCode($account->code,$account->name);
			echo '",';

			echo '"';
			echo "Group";
			echo '",';

			echo '"'.Yii::$app->Accounts->convertDcPrefix($account->op_total_dc,$account->op_total).'",';
			echo '"'.$account->dr_total.'",';
			echo '"'.$account->cr_total.'",';
			echo '"'.Yii::$app->Accounts->convertDcPrefix($account->cl_total_dc,$account->cl_total).'",';


			echo "\n";
		}

	/* Print child ledgers */
	if (count($account->children_ledgers) > 0) {
		$counter++;
		foreach ($account->children_ledgers as $id => $data) {
			
			echo '"';
			echo Yii::$app->Accounts->ledgerWithCode($data['code'],$data['name']);
			echo '",';
			echo '"';
			echo "Ledger";
			echo '",';

			echo '"';
			echo Yii::$app->Accounts->convertDcPrefix($data['op_total_dc'],$data['op_total']);
			echo '",';

			echo '"';
			echo $data['dr_total'];
			echo '",';

			echo '"';
			echo $data['cr_total'];
			echo '",';

			echo '"';
			echo Yii::$app->Accounts->convertDcPrefix($data['cl_total_dc'],$data['cl_total']);
			echo '",';
				

			echo "\n";
		}
		$counter--;
	}


	/* Print child groups recursively */
	foreach ($account->children_groups as $id => $data) {
		$counter++;
		print_account_chart($data, $counter, $THIS);
		$counter--;
	}
}



echo $this->title;
echo "\n";

if($openingDifference['amount'] != 0)
{
	$opening_dc=$openingDifference['amount_dc'] == 'D' ? 'C':'D';
	echo 'Difference in Opening Balance : '.Yii::$app->Accounts->convertDcPrefix($opening_dc,$openingDifference['amount']);
	echo "\n";
}


	echo '"' .'Account Name' . '",';
	echo '"' . 'Type' . '",';
	echo '"' . 'O/P Balance' .  '",';
	echo '"' . 'Debit Total' .  '",';
	echo '"' . 'Credit Total' .  '",';
	echo '"' .'C/L Balance' .  '",';
	echo "\n";	
	print_account_chart($accountlist, -1, $this);

	
	
	echo '"';
	echo 'TOTAL';
	echo '",';

	echo '"';
	echo '",';
	
	echo '"';
	echo '",';
	echo '"'.$accountlist->dr_total.'",';
	echo '"'.$accountlist->cr_total.'",';
	echo '"'.($accountlist->cr_total - $accountlist->dr_total).'",';
	

	
