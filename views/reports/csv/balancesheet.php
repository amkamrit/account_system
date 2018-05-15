

<?= '"'.$this->title.'",'."\n"; ?>

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
		echo print_space($counter);
		echo '",';

		echo "\n";
	}
	foreach ($account->children_groups as $id => $data)
	{
		$counter++;
		account_st_short($data, $counter, $THIS, $dc_type);
		$counter--;
	}
	if (count($account->children_ledgers) > 0)
	{
		$counter++;
		foreach ($account->children_ledgers as $id => $data)
		{
			
			
			echo '"';
			echo Yii::$app->Accounts->ledgerWithCode($data['code'],$data['name']);
			echo '",';

			echo '"';
			echo Yii::$app->Accounts->convertDcPrefix($data['cl_total_dc'],$data['cl_total']);
			
			echo '",';

			echo "\n";
		}
	$counter--;
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


?>

<?php 
	if($openingDifference['amount'] != 0)
	{
		$opening_dc=$openingDifference['amount_dc'] == 'D' ? 'C':'D';
		echo '"'."Difference in Opening Balance : ".Yii::$app->Accounts->convertDcPrefix($opening_dc,$openingDifference['amount']) .'",'."\n";
	}
?>

	<?php
		
		
					echo '"';
					echo 'Assets (Dr)';
					echo '",';

					echo '"';
					echo "Amount()";
					echo '",';
					echo "\n";
				
					echo account_st_short($bs['assets'], $c = -1, $this, 'D');
			



				/*  Assets Total */
				$grand_total_assets=$bs['assets_total'];
				$grand_total_dc_assets=$bs['assets_total_dc'];

				echo '"' . 'Total Assets' . '",';
				echo '"' . Yii::$app->Accounts->convertDcPrefix($bs['assets_total_dc'],$bs['assets_total']) . '",';
				echo "\n";
			
				
					/* Profit and Loss Account*/
					if ($bs['pl']['amount_dc'] == 'D') {
						echo '"' .'Profit & Loss Account (Net Loss)'.'",';
						echo '"' .$bs['pl']['amount'] . '",';
						echo "\n";
						if($bs['assets_total_dc'] == 'C')
						{
							$grand_total_assets=Yii::$app->Accounts->currentClosingBalance($bs['assets_total'],$bs['assets_total_dc'],$bs['pl']['amount'],$bs['pl']['amount_dc'])['amount'];
							$grand_total_dc_assets= Yii::$app->Accounts->currentClosingBalance($bs['assets_total'],$bs['assets_total_dc'],$bs['pl']['amount'],$bs['pl']['amount_dc'])['amount_dc'];
						}
						else
						{
							$grand_total_assets=$bs['assets_total'] + $bs['pl']['amount'];
						}
					} else {
						echo '"';
						echo '",';
						echo "\n";
					}
					
				

				/*<!-- Diff in OP -->*/
				
					
					if($bs['op']['amount'] == 0)
					{
						echo '"';
						echo '",';
						echo "\n";
					}
					else if ($bs['op']['amount_dc'] == 'C') {
						echo '"' .'O/P Balance'.'",';
						echo '"' .Yii::$app->Accounts->convertDcPrefix('D',$bs['op']['amount']). '",';
						$grand_total_assets=Yii::$app->Accounts->currentClosingBalance($grand_total_assets,$grand_total_dc_assets,$bs['op']['amount'],'D')['amount'];
						$grand_total_assets_dc=Yii::$app->Accounts->currentClosingBalance($grand_total_assets,$grand_total_dc_assets,$bs['op']['amount'],'D')['amount_dc'];
					} else {
						echo '"';
						echo '",';
						echo "\n";
					}

					echo '"';
					echo 'Total';
					echo '",';

					echo '"';
					echo Yii::$app->Accounts->convertDcPrefix($grand_total_dc_assets,$grand_total_assets);
					echo '",';
					echo "\n";
			


					//Liabilities
					echo "\n";
					echo '"';
					echo 'Liabilities (Cr)';
					echo '",';

					echo '"';
					echo "Amount()";
					echo '",';
					echo "\n";
					echo account_st_short($bs['liabilities'], $c = -1, $this, 'C');
	


				/* Liabilities Total */
				$grand_total_liabilities=$bs['liabilities_total'];
				$grand_total_dc_liabilities=$bs['liabilities_total_dc'];
				

				echo '"' . 'Total Liabilities'. '",';
				echo '"' .Yii::$app->Accounts->convertDcPrefix($bs['liabilities_total_dc'],$bs['liabilities_total']). '",';
				echo "\n";
			

					/* Profit and Loss Account */
					if ($bs['pl']['amount_dc'] == 'D')
					{
						echo '"';
						echo '",';
						echo "\n";
					} 
					else 
					{
						echo '"' .'Profit & Loss Account (Net Profit)' . '",';
						echo '"' .Yii::$app->Accounts->convertDcPrefix($bs['pl']['amount_dc'],$bs['pl']['amount']). '",';
						echo "\n";
						if($bs['liabilities_total_dc'] == 'D')
						{
							//$grand_total_liabilities=abs($bs['liabilities_total'] -  $bs['pl']['amount']);
							$grand_total_liabilities=Yii::$app->Accounts->currentClosingBalance($bs['liabilities_total'],$bs['liabilities_total_dc'],$bs['pl']['amount'],$bs['pl']['amount_dc'])['amount'];
							$grand_total_dc_liabilities= Yii::$app->Accounts->currentClosingBalance($bs['liabilities_total'],$bs['liabilities_total_dc'],$bs['pl']['amount'],$bs['pl']['amount_dc'])['amount_dc'];

						}
						else
						{
							$grand_total_liabilities=$bs['liabilities_total'] + $bs['pl']['amount'];
						}
					}
				

				/*<!-- Diff in OP -->*/
				
					if($bs['op']['amount'] == 0)
					{
						echo '"';
						echo '",';
						echo "\n";
					}
					else if ($bs['op']['amount_dc'] == 'D') {
						echo '"' .'O/P Balance'.'",';
						echo '"' .Yii::$app->Accounts->convertDcPrefix('C',$bs['op']['amount']). '",';
						echo "\n";
						//$grand_total_liabilities = $grand_total_liabilities+  $bs['op']['amount'];
						$grand_total_liabilities=Yii::$app->Accounts->currentClosingBalance($grand_total_liabilities,$grand_total_dc_liabilities,$bs['op']['amount'],'C')['amount'];
						$grand_total_dc_liabilities=Yii::$app->Accounts->currentClosingBalance($grand_total_liabilities,$grand_total_dc_liabilities,$bs['op']['amount'],'C')['amount_dc'];

					} else {
						echo '"';
						echo '",';
						echo "\n";
					}

					echo '"';
					echo 'Total'; 
					echo '",';
					

					echo '"';
					echo Yii::$app->Accounts->convertDcPrefix($grand_total_dc_liabilities,$grand_total_liabilities);
					echo '",';
					echo "\n";
				