<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LedgersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ledgers';

?>
<div class="ledgers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ledgers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'group_id',
            'name',
            'code',
            'op_balance',
            // 'op_balance_dc',
            // 'type',
            // 'reconciliation',
            // 'notes',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
