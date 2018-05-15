<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberaccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Product Manage';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberaccount-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Add More Product Manage', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'Sn',
            'Name',
            'Product_Name',
            'Size',
            'Weight',
            // 'Price',
            // 'Quantity',
            // 'Dr_Amount',
            // 'Cr_Amount',
            // 'Note:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
