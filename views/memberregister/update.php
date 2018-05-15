<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Memberregister */

$this->title = 'Update Member: ' . $model->Sn;
$this->params['breadcrumbs'][] = ['label' => 'Memberregisters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Sn, 'url' => ['view', 'id' => $model->Sn]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="memberregister-update" style="width: 60%;padding-left: 100px; padding-top: 30px;">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
