

<?php
use yii\helpers\Html;


$GLOBALS['grand_dr_total'] = 0; 
$GLOBALS['grand_cr_total'] = 0; 
function print_account_chart($account, $c = 0, $THIS)
{

	$counter = $c;

	/* Print groups */
	if ($account->id != 0) 
	{
			if($account->cl_total != 0)
			{
					if ($account->id <= 4) 
					{
						if ($account->cl_total_dc == 'D') 
						{
							$GLOBALS['grand_dr_total']+=$account->cl_total;
						}
						else
						{
							$GLOBALS['grand_cr_total']+=$account->cl_total;
						}
						echo '<tr class="info" style="font-weight:bold; font-size:15px">';
					} else {
						echo '<tr class="tr-group" style="font-weight:bold;">';
					}
					echo '<td class="td-group">';
					echo print_space($counter);
					echo Yii::$app->Accounts->ledgerWithCode($account->code,$account->name);
					echo '</td>';

					//echo '<td>Group</td>';

					/*echo '<td>'.Yii::$app->Accounts->convertDcPrefix($account->op_total_dc,$account->op_total).'</td>';
					echo '<td>'.$account->dr_total.'</td>';
					echo '<td>'.$account->cr_total.'</td>';
					echo '<td>'.Yii::$app->Accounts->convertDcPrefix($account->cl_total_dc,$account->cl_total).'</td>';*/
					if ($account->cl_total_dc == 'D') {
					echo '<td>' .round($account->cl_total,2). '</td>'; 
					echo '<td></td>';
					} else {
						echo '<td></td>';
						echo '<td>' .round($account->cl_total,2). '</td>';
					}


					echo '</tr>';
			}
	}

	/* Print child ledgers */
	if (count($account->children_ledgers) > 0) {
		$counter++;
		foreach ($account->children_ledgers as $id => $data) {
			if($data['cl_total'] != 0 && $data['cl_total'] > 0.0001)
			{
					echo '<tr class="tr-ledger">';
					echo '<td class="td-ledger">';
					echo print_space($counter);
					echo Html::a(Yii::$app->Accounts->ledgerWithCode($data['code'],$data['name']), ['/ledgers/ledgerstatement/','id'=>$data['id']], ['class'=>'']);
					echo '</td>';
					//echo '<td>Ledger</td>';

					/*echo '<td>';
					echo Yii::$app->Accounts->convertDcPrefix($data['op_total_dc'],$data['op_total']);
					echo '</td>';

					echo '<td>';
					echo $data['dr_total'];
					echo '</td>';

					echo '<td>';
					echo $data['cr_total'];
					echo '</td>';

					echo '<td>';
					echo Yii::$app->Accounts->convertDcPrefix($data['cl_total_dc'],$data['cl_total']);
					echo '</td>';*/

					if ($data['cl_total_dc'] == 'D') {
						echo '<td>' .$data['cl_total'] . '</td>'; 
							echo '<td></td>';
					} else {
							echo '<td></td>';
						echo '<td>' .round($data['cl_total'],2). '</td>'; 
					}
						

					echo '</tr>';
			}
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

function print_space($count)
{
	$html = '';
	for ($i = 1; $i <= $count; $i++) {
		$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	return $html;
}



echo $this->render('search',['search'=>$search]);
echo $this->render('../printHeader'); 
echo '<h4><b><center>'. $this->title .'</center></b></h4>';

if($openingDifference['amount'] != 0)
{
	$opening_dc=$openingDifference['amount_dc'] == 'D' ? 'C':'D';
	echo "<div class='alert alert-danger'>Difference in Opening Balance : ".Yii::$app->Accounts->convertDcPrefix($opening_dc,$openingDifference['amount']) ."</div>";
}

echo '<table class="table table-condensed table-bordered">';
	echo '<thead>';
	echo '<th>' .'Account Name' . '</th>';
	//echo '<th>' . 'Type' . '</th>';
	//echo '<th>' . 'O/P Balance' .  '</th>';
	echo '<th>' . 'Debit Total(Rs)' .  '</th>';
	echo '<th>' . 'Credit Total(Rs)' .  '</th>';
	echo '</thead>';
	//echo '<th>' .'C/L Balance' .  '</th>';	
	print_account_chart($accountlist, -1, $this);


	echo '<tr class="success">';
	echo '<td rowspan="3" style="font-size:20px">';
	echo '<b>TOTAL</b></td>';
	
	echo '<td style="font-size:20px"><b>'.$GLOBALS['grand_dr_total'].'</b></td>';
	echo '<td style="font-size:20px"><b>'.$GLOBALS['grand_cr_total'].'</b></td>';
	
	
	
echo '</table>';
