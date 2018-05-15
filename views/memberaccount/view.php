<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberaccount */

$this->title = $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Memberaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberaccount-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
         <a class="btn btn-primary" href="<?= Yii::$app->request->baseUrl.'/paynment'?>">Make Payment</a>
        <?= Html::a('Update', ['update', 'id' => $model->Sn], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->Sn], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'Sn',
            'Name',
            'Product_Name',
            'Size',
            'Weight',
            'Price',
            'Quantity',
            'Dr_Amount',
            'Cr_Amount',
            'Note:ntext',
        ],
    ]) ?>

</div>
