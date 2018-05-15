
<?php

/* @var $this yii\web\View */

$this->title = 'ACCOUNT OVERVIEW';
?>
<center><h2><b><?= $this->title; ?></b></h2></center><hr>
<div class="site-index">
	<div class="container">

		  <div class="row">
		  		<!-- Basic Information -->
		  		<div class="col-md-6">
					  <div class="panel-group">
						    <div class="panel panel-info">
							      <div class="panel-heading text-center"><b>INFORMATION</b></div>
							      <div class="panel-body">
							      		<table class="table">
							      				<tr>
													<td><b>ACCOUNT INFORMATION</b></td>
													<td><?= Yii::$app->Info->getClientName() ?></td>
												</tr>
												<tr>
													<td><b>FINANCIAL YEAR </b></td>
													<td><?= Yii::$app->Info->getClientFyStart() ?> TO <?= Yii::$app->Info->getClientFyEnd() ?></td>
												</tr>
												<tr>
													<td><b>ADDRESS</b></td>
													<td><?= Yii::$app->Info->getClientAddress() ?></td>
												</tr>
												<tr>
													<td><b>CONTACT NO</b></td>
													<td><?= Yii::$app->Info->getClientContactNo() ?></td>
												</tr>
												
										</table>

							      </div>
						    </div>
					   </div>
				</div>


				<div class="col-md-6">
					  <div class="panel-group">
						    <div class="panel panel-info">
							      <div class="panel-heading text-center"><b>ACCOUNTS</b></div>
							      <div class="panel-body">
							      		<table class="table">
							      				<tr>
													<td><b>ASSETS</b></td>
													<td><?= Yii::$app->Accounts->convertDcPrefix($bs['assets_total_dc'],$bs['assets_total']); ?></td>
												</tr>
												<tr>
													<td><b>LIABILITIES</b></td>
													<td><?= Yii::$app->Accounts->convertDcPrefix($bs['liabilities_total_dc'],$bs['liabilities_total']); ?></td>
												</tr>
												<tr>
													<td><b>INCOMES</b></td>
													<td><?= Yii::$app->Accounts->convertDcPrefix($bs['incomes_total_dc'],$bs['incomes_total']); ?></td>
												</tr>
												<tr>
													<td><b>EXPENSES</b></td>
													<td><?= Yii::$app->Accounts->convertDcPrefix($bs['expenses_total_dc'],$bs['expenses_total']); ?></td>
												</tr>
												
										</table>

							      </div>
						    </div>
					   </div>
				</div>



		 </div>
	</div>

</div>

