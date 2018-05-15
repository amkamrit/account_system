
<body style="align-items: center;background: #e6f9ff; margin:200px">
	<center><h2><b>Select Your Account/Year</b></h2></center>
	<div style="text-align: center;">
			<form action="<?php echo Yii::$app->request->baseUrl.'/site/index' ?>" method="get">
					<select name="database">
					  <option value="sch_2074/75" selected>sch_2074/75</option>
					  <option value="tilingatar_2073/74" selected>Tilingatar_2074/75</option>
					   <option value="temp_acc" selected>Blank</option>
					</select>
					<br><br>
					<input type="submit" value="SELECT">
			</form>
	</div>
</body>