<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberaccount */

$this->title = 'Update Memberaccount: ' . $model->Name;
$this->params['breadcrumbs'][] = ['label' => 'Memberaccounts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Name, 'url' => ['view', 'id' => $model->Sn]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="memberaccount-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
