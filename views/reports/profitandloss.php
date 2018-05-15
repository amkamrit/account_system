
<?php echo $this->render('search',['search'=>$search]); ?>
<?php echo $this->render('../printHeader'); ?>
<h4><b><center><?= $this->title ?></center></b></h4>
<?php
use yii\helpers\Html;
//Printing all Groups and Ledgers
function account_st_short($account, $c = 0, $THIS, $dc_type)
{
	$counter = $c;
	if ($account->id > 4)
	{
		if(($dc_type == $account->cl_total_dc) || $account->cl_total == 0)echo '<tr>';
		else echo '<tr class="warning">';
		echo '<td class="td-group"><b>';
		echo print_space($counter);
		echo Yii::$app->Accounts->ledgerWithCode($account->code,$account->name);
		echo '</td></b>';

		echo '<td class="text-right">';
		echo Yii::$app->Accounts->convertDcPrefix($account->cl_total_dc,round($account->cl_total,2));
		echo print_space($counter);
		echo '</td>';

		echo '</tr>';
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
			
			if(($dc_type == $data['cl_total_dc']) || $data['cl_total'] == 0)echo '<tr>';
			else echo '<tr class="warning">';
			echo '<td class="td-ledger">';
			echo print_space($counter);
			echo Html::a(Yii::$app->Accounts->ledgerWithCode($data['code'],$data['name']), ['/ledgers/ledgerstatement/','id'=>$data['id']], ['class'=>'']);
			
			echo '</td>';

			echo '<td class="text-right">';
			echo Yii::$app->Accounts->convertDcPrefix($data['cl_total_dc'],round($data['cl_total'],2));
			echo print_space($counter);
			echo '</td>';

			echo '</tr>';
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

$gross_total = 0;
$positive_gross_pl = 0;
$net_expense_total = 0;
$net_income_total = 0;
$positive_net_pl = 0;

?>



<br />





<table class="table table-bordered">

	<tr>
		<!-- Gross Expenses -->
		<td class="table-top width-50">
			<table class="table">
				<tr>
					<th><?php echo 'Gross Expenses (Dr)' ?></th>
					<th class="text-right"><?php echo "Amount(Rs)" ?></th>
				</tr>
				<?php echo account_st_short($pal['gross_expenses'], $c = -1, $this, 'D'); ?>
			</table>
		</td>

		<!-- Gross Incomes -->
		<td class="table-top width-50">
			<table class="table">
				<tr>
					<th><?php echo 'Gross Incomes (Cr)' ?></th>
					<th class="text-right"><?php echo "Amount(Rs)" ?></th>
				</tr>
				<?php echo account_st_short($pal['gross_incomes'], $c = -1, $this, 'C'); ?>
			</table>
		</td>
	</tr>

	<tr>
		<td class="table-top width-50">
			<div></div>
			<table class="table">
				<?php
				/* Gross Expense Total */
				$gross_total=$pal['gross_expense_total'];
				$gross_total_dc=$pal['gross_expense_total_dc'];
				if ($pal['gross_expense_total_dc'] == 'D') {
					echo '<tr class="info">';
					echo '<td>' . 'Total Gross Expenses' . '</td>';
					echo '<td class="text-right">' . Yii::$app->Accounts->convertDcPrefix($pal['gross_expense_total_dc'],$pal['gross_expense_total']) . '</td>';
					echo '</tr>';
				} else {
					echo '<tr class="warning">';
					echo '<td>' . 'Total Gross Expenses'. '</td>';
					echo '<td class="text-right">' .  Yii::$app->Accounts->convertDcPrefix($pal['gross_expense_total_dc'],$pal['gross_expense_total']) . '</td>';
					echo '</tr>';
				}
				?>
				<tr>
					<?php
					/* Gross Profit C/D */
					if($pal['grossData']['amount'] == 0)
					{
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					else if ($pal['grossData']['amount_dc'] == 'C') {
						echo '<td>' .'Gross Profit C/D'.'</td>';
						echo '<td class="text-right">' .$pal['grossData']['amount'] . '</td>';
						if($pal['gross_expense_total_dc'] == 'C')
						{
							$gross_total=abs($pal['gross_expense_total'] - $pal['grossData']['amount']);
						}
						else
						{
							$gross_total=$pal['gross_expense_total'] + $pal['grossData']['amount'];
						}
					} else {
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					?>
				</tr>
				<tr class="bold-text bg-filled">
					<td><?php echo 'Total'; ?></td>
					<td class="text-right"><?php echo Yii::$app->Accounts->convertDcPrefix($gross_total_dc,$gross_total); ?></td>
				</tr>
			</table>
		</td>

		<td class="table-top width-50">
			<div class="report-tb-pad"></div>
			<table class="table">
				<?php
				/* Gross Income Total */
				$gross_total=$pal['gross_income_total'];
				$gross_total_dc=$pal['gross_income_total_dc'];
				if ($pal['gross_income_total_dc'] == 'C') {
					echo '<tr class="info">';
					echo '<td>' . 'Total Gross Incomes'. '</td>';
					echo '<td class="text-right">' .Yii::$app->Accounts->convertDcPrefix($pal['gross_income_total_dc'] ,$pal['gross_income_total']) . '</td>';
					echo '</tr>';
				} else {
					echo '<tr class="warning">';
					echo '<td>' . 'Total Gross Incomes'. '</td>';
					echo '<td class="text-right">' .Yii::$app->Accounts->convertDcPrefix($pal['gross_income_total_dc'] ,$pal['gross_income_total']) . '</td>';
					echo '</tr>';
				}
				?>
				<tr class="bold-text">
					<?php
					/* Gross Loss C/D */
					if($pal['grossData']['amount'] == 0)
					{
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					else if ($pal['grossData']['amount_dc'] == 'C') {
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					} 
					else {
						echo '<td>' .'Gross Loss C/D' . '</td>';
						echo '<td class="text-right">' .$pal['grossData']['amount']. '</td>';
						if($pal['gross_income_total_dc'] == 'D')
						{
							$gross_total=abs($pal['gross_income_total'] - $pal['grossData']['amount']);
						}
						else
						{
							$gross_total=$pal['gross_income_total'] + $pal['grossData']['amount'];
						}
					}
					?>
				</tr>
				<tr class="bold-text bg-filled">
					<td><?php echo 'Total'; ?></td>
					<td class="text-right"><?php echo Yii::$app->Accounts->convertDcPrefix($gross_total_dc,$gross_total); ?></td>
				</tr>
			</table>
		</td>

	</tr>

	<!-- Net Profit and Loss -->
	<tr>
		<td class="table-top width-50">
		
			<table class="table">
				<tr>
					<th><?php echo 'Net Expenses (Dr)' ?></th>
					<th class="text-right"><?php echo 'Amount(Rs)'; ?></th>
				</tr>
				<?php echo account_st_short($pal['net_expenses'], $c = -1, $this, 'D'); ?>
			</table>
		</td>

		<td class="table-top width-50">
			<div class="report-tb-pad"></div>
			<table class="table">
				<tr>
					<th><?php echo 'Net Incomes (Cr)'; ?></th>
					<th class="text-right"><?php echo 'Amount(Rs)'; ?></th>
				</tr>
				<?php echo account_st_short($pal['net_incomes'], $c = -1, $this, 'C'); ?>
			</table>
		</td>
	</tr>

	<tr>
		<td class="table-top width-50">
			<div class="report-tb-pad"></div>
			<table class="table">
				<?php
				/* Net Expense Total */
				$net_expense_total = $pal['net_expense_total'];
				$net_expense_total_dc = $pal['net_expense_total_dc'];
				
				if ($pal['net_expense_total_dc'] == 'D') {
					echo '<tr class="bold-text">';
					echo '<td>' . 'Total Expenses' . '</td>';
					echo '<td class="text-right">' .$pal['net_expense_total'] . '</td>';
					echo '</tr>';
				} else {
					echo '<tr class="warning">';
					echo '<td>' .'Total Expenses' . '</td>';
					echo '<td class="text-right">' . $pal['net_expense_total'] . '</td>';
					echo '</tr>';
				}
				?>
				<tr class="bold-text">
					<?php
					/* Gross Loss B/D */
					if ($pal['grossData']['amount_dc'] == 'C') {
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					} else {
						echo '<td>' .'Gross Loss B/D' . '</td>';
						echo '<td class="text-right">' .  $pal['netData']['grossPl'] . '</td>';

						if($pal['net_expense_total_dc'] == 'C')
						{
							$net_expense_total = abs($net_expense_total -  $pal['netData']['grossPl']);
						}
						else
						{
							$net_expense_total = $net_expense_total+  $pal['netData']['grossPl'];
						}

					}
					?>
				</tr>
				<tr class="bold-text ok-text">
					<?php
					/* Net Profit */
					if($pal['netData']['amount'] == 0)
					{
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					else if ($pal['netData']['amount_dc'] == 'C') {
						echo '<td>' .'Net Profit' . '</td>';
						echo '<td class="text-right">' .$pal['netData']['amount'] . '</td>';
						$net_expense_total = $net_expense_total+  $pal['netData']['grossPl'];
					} else {
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					?>
				</tr>
				<tr class="bold-text bg-filled">
					<td><?php echo 'Total'; ?></td>
					<td class="text-right"><?php echo  $net_expense_total; ?></td>
				</tr>
			</table>
		</td>

		<td class="table-top width-50">
			<div class="report-tb-pad"></div>
			<table class="table">
				<?php
				/* Net Income Total */
				$net_income_total = $pal['net_income_total'];
				$net_income_total_dc = $pal['net_income_total_dc'];
				if ($pal['net_income_total_dc'] == 'D') {
					echo '<tr class="bold-text">';
					echo '<td>' .'Total Incomes' . '</td>';
					echo '<td class="text-right">' . $pal['net_income_total'] . '</td>';
					echo '</tr>';
				} else {
					echo '<tr class="warning">';
					echo '<td>' . 'Total Incomes' . '</td>';
					echo '<td class="text-right">' .  $pal['net_income_total'] . '</td>';
					echo '</tr>';
				}
				?>
				
				<tr class="bold-text">
					<?php
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
						
						echo '<td>' .'Gross Profit C/D'. '</td>';
						echo '<td class="text-right">' .   $pal['grossData']['amount'].'</td>';
					} else {
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					?>
				</tr>

				<tr class="bold-text ok-text">
					<?php
					/* Net Loss */
					if($pal['netData']['amount'] == 0)
					{
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					else if ($pal['netData']['amount_dc'] == 'C') {
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					} else {
						echo '<td>' .'Net Loss' . '</td>';
						
						echo '<td class="text-right">' .$pal['netData']['amount'] . '</td>';
						$net_income_total=$net_income_total+$pal['netData']['amount'];
					}
					?>
				</tr>
				<tr class="bold-text bg-filled">
					<td><?php echo 'Total'; ?></td>
					<td class="text-right"><?php echo $net_income_total; ?></td>
				</tr>
			</table>
		</td>
	</tr>
</table>