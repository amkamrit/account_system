<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ledgers */

$this->title = 'Update Ledgers: ' . $model->name;

?>
<div class="ledgers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ledger_options'=>$ledger_options
    ]) ?>

</div>
