<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Memberregister */

$this->title = 'New Member Register';
$this->params['breadcrumbs'][] = ['label' => 'Memberregisters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memberregister-create" style="width: 70%; padding-left: 100px; padding-top: 20px;">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
