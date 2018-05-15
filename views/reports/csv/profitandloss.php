

<?= $this->title."\n" ?>
<?php
use yii\helpers\Html;
//Printing all Groups and Ledgers
function account_st_short($account, $c = 0, $THIS, $dc_type)
{
	$counter = $c;
	if ($account->id > 4)
	{
		
		echo '"';
		echo Yii::$app->Accounts->ledgerWithCode($account->code,$account->name);
		echo '",';

		echo '"';
		echo Yii::$app->Accounts->convertDcPrefix($account->cl_total_dc,$account->cl_total);
		echo '",';

		echo "\n";
	}
	foreach ($account->children_groups as $id => $data)
	{
		
		account_st_short($data, $counter, $THIS, $dc_type);
		
	}
	if (count($account->children_ledgers) > 0)
	{
		
		foreach ($account->children_ledgers as $id => $data)
		{
			
			echo '"';
			echo Yii::$app->Accounts->ledgerWithCode($data['code'],$data['name']);
			echo '",';

			echo '"';
			echo Yii::$app->Accounts->convertDcPrefix($data['cl_total_dc'],$data['cl_total']);
			echo print_space($counter);
			echo '",';

			echo "\n";
		}
	
	}
}

function print_space($count)
{
	$html = '';
	for ($i = 1; $i <= $count; $i++) {
		$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	return $html;
}

$gross_total = 0;
$positive_gross_pl = 0;
$net_expense_total = 0;
$net_income_total = 0;
$positive_net_pl = 0;

?>


<?php

					//Expenses
					echo '"'.'Gross Expenses (Dr)'.'",'; 
					echo '"'.'Amount (Rs)'.'",';
					echo "\n";
					echo account_st_short($pal['gross_expenses'], $c = -1, $this, 'D');
					


					$gross_total=$pal['gross_expense_total'];
					$gross_total_dc=$pal['gross_expense_total_dc'];
				
					echo '"'.'Total Gross Expenses'.'",';
					echo '"' .  Yii::$app->Accounts->convertDcPrefix($pal['gross_expense_total_dc'],$pal['gross_expense_total']) . '",';
					
					echo "\n";

		
				
				/* Gross Expense Total */
				$gross_total=$pal['gross_expense_total'];
				$gross_total_dc=$pal['gross_expense_total_dc'];
				if ($pal['gross_expense_total_dc'] == 'D') {
					echo '"' . 'Total Gross Expenses' . '",';
					echo '"' . Yii::$app->Accounts->convertDcPrefix($pal['gross_expense_total_dc'],$pal['gross_expense_total']) . '",';
					echo "\n";
				} else {
					echo '"' . 'Total Gross Expenses' . '",';
					echo '"' .  Yii::$app->Accounts->convertDcPrefix($pal['gross_expense_total_dc'],$pal['gross_expense_total']) . '",';
					echo "\n";
				}
				

					/* Gross Profit C/D */
					if($pal['grossData']['amount'] == 0)
					{
						echo '"';
						echo '",';
						echo "\n";
					}
					else if ($pal['grossData']['amount_dc'] == 'C') {
						echo '"' .'Gross Profit C/D'.'",';
						echo '"' .$pal['grossData']['amount'] . '",';
						echo "\n";
						if($pal['gross_expense_total_dc'] == 'C')
						{
							$gross_total=abs($pal['gross_expense_total'] - $pal['grossData']['amount']);
						}
						else
						{
							$gross_total=$pal['gross_expense_total'] + $pal['grossData']['amount'];
						}
					} else {
						echo '"';
						echo '",';
						echo "\n";
					}
					
					echo '"';
					echo 'Total'; 
					echo '",';

					echo '"';
					echo Yii::$app->Accounts->convertDcPrefix($gross_total_dc,$gross_total);
					echo '",';
					echo "\n";
					echo "\n";
				


					//Incomes
					echo '"'.'Gross Incomes (Cr)'.'",';
					echo '"'.'Amount (Rs)'.'",';
					echo "\n";
					echo account_st_short($pal['gross_incomes'], $c = -1, $this, 'C');

		
				/* Gross Income Total */
				$gross_total=$pal['gross_income_total'];
				$gross_total_dc=$pal['gross_income_total_dc'];
				if ($pal['gross_income_total_dc'] == 'C') {
					echo '"' . 'Total Gross Incomes'. '",';
					echo '"' .Yii::$app->Accounts->convertDcPrefix($pal['gross_income_total_dc'] ,$pal['gross_income_total']) . '",';
					echo "\n";
				} else {
					echo '"' . 'Total Gross Incomes'. '",';
					echo '"' .Yii::$app->Accounts->convertDcPrefix($pal['gross_income_total_dc'] ,$pal['gross_income_total']) . '",';
					echo "\n";
				}
				
					/* Gross Loss C/D */
					if($pal['grossData']['amount'] == 0)
					{
						echo '"';
						echo '",';
						echo "\n";
					}
					else if ($pal['grossData']['amount_dc'] == 'C') {
						echo '"';
						echo '",';
						echo "\n";
					} 
					else {
						echo '"' .'Gross Loss C/D' . '",';
						echo '"' .$pal['grossData']['amount']. '"';
						echo "\n";
						if($pal['gross_income_total_dc'] == 'D')
						{
							$gross_total=abs($pal['gross_income_total'] - $pal['grossData']['amount']);
						}
						else
						{
							$gross_total=$pal['gross_income_total'] + $pal['grossData']['amount'];
						}
					}
					

					echo '"';
					echo 'Total'; 
					echo '",';
					echo '"';
					echo Yii::$app->Accounts->convertDcPrefix($gross_total_dc,$gross_total); 
					echo '",';
					echo "\n\n";

/*
	<!-- Net Profit and Loss -->*/
	
					echo '"';
					echo 'Net Expenses (Dr)';
					echo '",';

					echo '"';
					echo 'Amount(Rs)';
					echo '",';
					echo "\n";
					echo account_st_short($pal['net_expenses'], $c = -1, $this, 'D');

				/* Net Expense Total */
				$net_expense_total = $pal['net_expense_total'];
				$net_expense_total_dc = $pal['net_expense_total_dc'];
				
				if ($pal['net_expense_total_dc'] == 'D') {
					
					echo '"' . 'Total Expenses' . '",';
					echo '"' .$pal['net_expense_total'] . '",';
					echo "\n";
				} else {
					echo '"' . 'Total Expenses' . '",';
					echo '"' .$pal['net_expense_total'] . '",';
					echo "\n";
				}
				
					/* Gross Loss B/D */
					if ($pal['grossData']['amount_dc'] == 'C') {
						echo '"';
						echo '",';
						echo "\n";
					} else {
						echo '"' .'Gross Loss B/D' . '",';
						echo '"' .  $pal['netData']['grossPl'] . '",';
						echo "\n";

						if($pal['net_expense_total_dc'] == 'C')
						{
							$net_expense_total = abs($net_expense_total -  $pal['netData']['grossPl']);
						}
						else
						{
							$net_expense_total = $net_expense_total+  $pal['netData']['grossPl'];
						}

					}
					

					/* Net Profit */
					if($pal['netData']['amount'] == 0)
					{
						echo '"';
						echo '",';
						echo "\n";
					}
					else if ($pal['netData']['amount_dc'] == 'C') {
						echo '"' .'Net Profit' . '",';
						echo '"' .$pal['netData']['amount'] . '",';
						echo "\n";
						$net_expense_total = $net_expense_total+  $pal['netData']['grossPl'];
					} else {
						echo '"';
						echo '",';
						echo "\n";
					}
					
					echo '"';
					echo 'Total';
					echo '",';

					echo '"';
					echo  $net_expense_total;
					echo '",';
					echo "\n\n";




				echo '"Net Incomes (Cr)",';
				echo '"Amount(Rs)",'; 
				echo "\n";
				echo account_st_short($pal['net_incomes'], $c = -1, $this, 'C');


				/* Net Income Total */
				$net_income_total = $pal['net_income_total'];
				$net_income_total_dc = $pal['net_income_total_dc'];
				if ($pal['net_income_total_dc'] == 'D') {
					echo '"' .'Total Incomes' . '",';
					echo '"' . $pal['net_income_total'] . '",';
					echo "\n";
				} else {
					echo '"' . 'Total Incomes' . '",';
					echo '"' .  $pal['net_income_total'] . '",';
					echo "\n";
				}
				
				
				
					/* Gross Profit B/D */
					if ($pal['grossData']['amount_dc'] == 'C') 
					{
						if($pal['net_income_total_dc'] == 'C')
						{
							$net_income_total = abs($net_income_total -  $pal['netData']['grossPl']);
						}
						else
						{
							$net_income_total = $net_income_total + $pal['netData']['grossPl'];
						}
						
						echo '"' .'Gross Profit C/D'. '",';
						echo '"' .   $pal['grossData']['amount'].'",';
						echo "\n";
					} else {
						echo '"';
						echo '",';
						echo "\n";
					}
					

					/* Net Loss */
					if($pal['netData']['amount'] == 0)
					{
						echo '"';
						echo '",';
						echo "\n";
					}
					else if ($pal['netData']['amount_dc'] == 'C') {
						echo '"';
						echo '",';
						echo "\n";
					} else {
						echo '"' .'Net Loss' . '",';
						
						echo '"' .$pal['netData']['amount'] . '",';
						echo "\n";
						$net_income_total=$net_income_total+$pal['netData']['amount'];
					}
					
					echo '"Total",';
					echo '"'.$net_income_total.'",'."\n";

	?>