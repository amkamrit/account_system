<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Paynment */

$this->title = 'Update Paynment: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Paynments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="paynment-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
