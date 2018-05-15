<center><h2><b><?= $this->title; ?></b></h2></center><hr>
<?php
use yii\helpers\Html;

function print_account_chart($account, $c = 0, $THIS)
{

	$counter = $c;

	/* Print groups */
	if ($account->id != 0) {
		if ($account->id <= 4) {
			echo '<tr class="info" style="font-weight:bold; font-size:15px">';
		} else {
			echo '<tr class="tr-group">';
		}
		echo '<td class="td-group">';
		echo print_space($counter);
		echo Yii::$app->Accounts->ledgerWithCode($account->code,$account->name);
		echo '</td>';

		echo '<td>Group</td>';

		echo '<td>-</td>';
		echo '<td>-</td>';

		/* If group id less than 4 dont show edit and delete links */
		if ($account->id <= 4) {
			echo '<td class="td-actions"></td>';
		} else {
			echo '<td class="td-actions">';
			echo "<a class='btn btn-info' href=".Yii::$app->request->baseUrl."/groups/update/".$account->id.">EDIT</a>";
			echo "&nbsp;";
			echo Html::a("DELETE", ['/groups/delete/', 'id' => $account->id], [
		        'class' => 'btn btn-danger',
		        'data' => [
		            'confirm' =>'Are you sure you want to delete this group?',
		            'method' => 'get',
		        ],
		    ]); 
			echo '</td>';
		}
		echo '</tr>';
	}

	/* Print child ledgers */
	if (count($account->children_ledgers) > 0) {
		$counter++;
		foreach ($account->children_ledgers as $id => $data) {
			echo '<tr class="tr-ledger">';
			echo '<td class="td-ledger">';
			echo print_space($counter);
			echo Html::a(Yii::$app->Accounts->ledgerWithCode($data['code'],$data['name']), ['/ledgers/ledgerstatement/','id'=>$data['id']], ['class'=>'']);
			echo '</td>';
			echo '<td>Ledger</td>';

			echo '<td>';
			echo Yii::$app->Accounts->convertDcPrefix($data['op_total_dc'],$data['op_total']);
			echo '</td>';

			echo '<td>';
			echo Yii::$app->Accounts->convertDcPrefix($data['cl_total_dc'],$data['cl_total']);
			echo '</td>';

			echo '<td class="td-actions">';
			echo "<a class='btn btn-info' href=".Yii::$app->request->baseUrl."/ledgers/update/".$data['id'].">EDIT</a>";
			echo "&nbsp;";
			echo Html::a("DELETE", ['/ledgers/delete/', 'id' => $data['id']], [
		        'class' => 'btn btn-danger',
		        'data' => [
		            'confirm' =>'Are you sure you want to delete this ledgers?',
		            'method' => 'get',
		        ],
		    ]); 
			echo '</td>';

			echo '</tr>';
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

if($openingDifference['amount'] != 0)
{
	$opening_dc=$openingDifference['amount_dc'] == 'D' ? 'C':'D';
	echo "<div class='alert alert-danger'>Difference in Opening Balance : ".Yii::$app->Accounts->convertDcPrefix($opening_dc,$openingDifference['amount']) ."</div>";
}
echo Html::a('Add Group', ['/groups/create'], ['class'=>'btn btn-primary']);
echo "&nbsp;&nbsp;&nbsp;&nbsp;";
echo Html::a('Add Ledger', ['/ledgers/create'], ['class'=>'btn btn-primary']);

echo '<table class="table table-condensed">';
	echo '<th>' .'Account Name' . '</th>';
	echo '<th>' . 'Type' . '</th>';
	echo '<th>' . 'O/P Balance' .  '</th>';
	echo '<th>' .'C/L Balance' .  '</th>';
	echo '<th>' .'Actions'. '</th>';	
	print_account_chart($accountlist, -1, $this);
echo '</table>';
