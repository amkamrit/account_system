<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Groups */

$this->title = 'Update Groups: ' . $model->name;


?>
<div class="groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ledger_options'=>$ledger_options
    ]) ?>

</div>
