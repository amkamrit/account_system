
<?php
use yii\helpers\Html;
use yii\grid\GridView;


?>


<?php echo $this->render('search',['search'=>$search]); ?>
<?php echo $this->render('../printHeader'); ?>
<h4><b><center><?= $this->title ?></center></b></h4>

<table class="table table-bordered table-condensed">
<thead>
    <th style="width:120px">Date</th>
    <th>Number</th>
    <th>Narration</th>
    <th>Debit Amount</th>
    <th>Credit Amount</th>
    <th class="hidden-print">Action</th>
</thead>
    <?php if($entries != null)
    { ?>

        <?php foreach ($entries as $key => $value) { ?>
            <tr>
            <td><?= $value->date ?></td>
            <td><?= $value->number ?></td>
            <td><?= $value->narration ?></td>
            <td><?= $value->dr_total ?></td>
            <td><?= $value->cr_total ?></td>
            <td class="hidden-print"><a href="<?= Yii::$app->request->baseUrl.'/entries/'.$value->id ?>" target="_blank">VIEW</a></td>

            </tr>


        <?php } ?>
    <?php } ?>

</table>