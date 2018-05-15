<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Paynment */

$this->title = 'Create Paynment';
$this->params['breadcrumbs'][] = ['label' => 'Paynments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paynment-create" style="width: 70%; padding-top: 30px; padding-left: 300px;">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
