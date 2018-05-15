<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MemberregisterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Member Registers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberregister-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('New Member Register', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'Sn',
            'Name',
            'Address',
            'Code',
            'Company_Name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
