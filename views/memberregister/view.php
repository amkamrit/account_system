<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberregister */

$this->title = $model->Sn;
$this->params['breadcrumbs'][] = ['label' => 'Memberregisters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberregister-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'Address',
            'Code',
            'Company_Name',
        ],
    ]) ?>

</div>
