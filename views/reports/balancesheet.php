
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


?>



<br />


<?php 
	if($openingDifference['amount'] != 0)
	{
		$opening_dc=$openingDifference['amount_dc'] == 'D' ? 'C':'D';
		echo "<div class='alert alert-danger'>Difference in Opening Balance : ".Yii::$app->Accounts->convertDcPrefix($opening_dc,$openingDifference['amount']) ."</div>";
	}
?>
<table class="table table-bordered">

	<tr>
		<!-- Assets -->
		<td class="col-md-6">
			<table class="table">
				<tr>
					<th><?php echo 'Assets (Dr)' ?></th>
					<th class="text-right"><?php echo "Amount()" ?></th>
				</tr>
				<?php echo account_st_short($bs['assets'], $c = -1, $this, 'D'); ?>
			</table>
		</td>

		<!-- Liabilities -->
		<td class="col-md-6">
			<table class="table">
				<tr>
					<th><?php echo 'Liabilities (Cr)' ?></th>
					<th class="text-right"><?php echo "Amount()" ?></th>
				</tr>
				<?php echo account_st_short($bs['liabilities'], $c = -1, $this, 'C'); ?>
			</table>
		</td>
	</tr>

	<tr>
		<td>
			<div></div>
			<table class="table">
				<?php
				/*  Assets Total */
				$grand_total_assets=$bs['assets_total'];
				$grand_total_dc_assets=$bs['assets_total_dc'];
				if ($bs['assets_total_dc'] == 'D') echo '<tr class="info">';
				else echo '<tr class="warning">';

				echo '<td>' . 'Total Assets' . '</td>';
				echo '<td class="text-right">' . Yii::$app->Accounts->convertDcPrefix($bs['assets_total_dc'],$bs['assets_total']) . '</td>';
				echo '</tr>';
			
				?>
				<tr>
					<?php
					/* Profit and Loss Account*/
					if ($bs['pl']['amount_dc'] == 'D') {
						echo '<td>' .'Profit & Loss Account (Net Loss)'.'</td>';
						echo '<td class="text-right">' .$bs['pl']['amount'] . '</td>';
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
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					?>
				</tr>

				<!-- Diff in OP -->
				<tr>
					<?php
					if($bs['op']['amount'] == 0)
					{
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					else if ($bs['op']['amount_dc'] == 'C') {
						echo '<td class="bg-success">' .'O/P Balance'.'</td>';
						echo '<td class="text-right bg-success">' .Yii::$app->Accounts->convertDcPrefix('D',$bs['op']['amount']). '</td>';
						$grand_total_assets=Yii::$app->Accounts->currentClosingBalance($grand_total_assets,$grand_total_dc_assets,$bs['op']['amount'],'D')['amount'];
						$grand_total_assets_dc=Yii::$app->Accounts->currentClosingBalance($grand_total_assets,$grand_total_dc_assets,$bs['op']['amount'],'D')['amount_dc'];
					} else {
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					?>
				</tr>


				<tr class="bg-primary">
					<td><?php echo 'Total'; ?></td>
					<td class="text-right"><?php echo Yii::$app->Accounts->convertDcPrefix($grand_total_dc_assets,$grand_total_assets); ?></td>
				</tr>
			</table>
		</td>

		<td>
			
			<table class="table">
				<?php
				/* Liabilities Total */
				$grand_total_liabilities=$bs['liabilities_total'];
				$grand_total_dc_liabilities=$bs['liabilities_total_dc'];
				if ($bs['liabilities_total_dc'] == 'D') echo '<tr class="warning">';
				else echo '<tr class="info">';

				echo '<td>' . 'Total Liabilities'. '</td>';
				echo '<td class="text-right">' .Yii::$app->Accounts->convertDcPrefix($bs['liabilities_total_dc'],$bs['liabilities_total']). '</td>';
				echo '</tr>';
				?>
				<tr class="bold-text">
					<?php
					/* Profit and Loss Account */
					if ($bs['pl']['amount_dc'] == 'D')
					{
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					} 
					else 
					{
						echo '<td>' .'Profit & Loss Account (Net Profit)' . '</td>';
						echo '<td class="text-right">' .Yii::$app->Accounts->convertDcPrefix($bs['pl']['amount_dc'],$bs['pl']['amount']). '</td>';
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
					?>
				</tr>

				<!-- Diff in OP -->
				<tr>
					<?php
					if($bs['op']['amount'] == 0)
					{
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					else if ($bs['op']['amount_dc'] == 'D') {
						echo '<td class="bg-danger">' .'O/P Balance'.'</td>';
						echo '<td class="text-right bg-danger">' .Yii::$app->Accounts->convertDcPrefix('C',$bs['op']['amount']). '</td>';
						//$grand_total_liabilities = $grand_total_liabilities+  $bs['op']['amount'];
						$grand_total_liabilities=Yii::$app->Accounts->currentClosingBalance($grand_total_liabilities,$grand_total_dc_liabilities,$bs['op']['amount'],'C')['amount'];
						$grand_total_dc_liabilities=Yii::$app->Accounts->currentClosingBalance($grand_total_liabilities,$grand_total_dc_liabilities,$bs['op']['amount'],'C')['amount_dc'];

					} else {
						echo '<td>&nbsp</td>';
						echo '<td>&nbsp</td>';
					}
					?>
				</tr>
				<tr class="bg-primary">
					<td><?php echo 'Total'; ?></td>
					<td class="text-right"><?php echo Yii::$app->Accounts->convertDcPrefix($grand_total_dc_liabilities,$grand_total_liabilities); ?></td>
				</tr>
			</table>
		</td>

	</tr>

	
</table>