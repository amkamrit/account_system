

<?php

/* @var $this yii\web\View */

$this->title = 'SETTING';
?>
<style type="text/css">
	
.mybutton
{
	width:300px; height:50px;text-align: center; display:table-cell;vertical-align: middle;
}

</style>
<center><h2><b><?= $this->title; ?></b></h2></center><hr>
<center>
<a href="<?= Yii::$app->request->baseUrl.'/carry-forward' ?>" class="btn btn-info mybutton"><b>CARRY FORWARD TO NEXT YEAR</b></a><hr>
<a href="<?= Yii::$app->request->baseUrl.'/initial-setup/update' ?>" class="btn btn-info mybutton"><b>UPDATE MY INFORMATION</b></a><hr>
<a href="<?= Yii::$app->request->baseUrl.'/tags' ?>" class="btn btn-info mybutton"><b>TAGS</b></a><hr>
<a href="<?= Yii::$app->request->baseUrl.'/site/change-password' ?>" class="btn btn-info mybutton"><b>CHANGE PASSWORD</b></a>

</center>