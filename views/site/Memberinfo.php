<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>
<?php foreach ($memberAccount as $memberaccount):?>


                  <?php $id=$memberaccount->Name ?>
                  <?php echo $id?>
                 
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>

<table>
  <tr>
    <th>Name</th>
    <th>Dr_Amount</th>
    <th>Cr_Amount</th>
    <th>Balcnced</th>
  </tr>
  <tr>
    <td>
    	<?= Html::encode("{$memberaccount->Name}") ?></td>
    
    <td><?php $dr=$memberaccount->Dr_Amount?>
    	<?= Html::encode("{$memberaccount->Dr_Amount}") ?></td>
    
    <td><?php $cr=$memberaccount->Cr_Amount?>
    	<?= Html::encode("{$memberaccount->Cr_Amount}") ?></td>
    <td><?php echo $c=$cr-$dr; ?></td>
  </tr>
 
</table>               

<?php endforeach; ?>
</body>
</html>
