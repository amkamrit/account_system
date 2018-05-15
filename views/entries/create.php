<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Entries */

$this->title = 'Create Journal Entry';

?>
<div class="entries-create">

 <h2><center><b><?= strtoupper($this->title) ?></b></center></h2> <hr>

    <?= $this->render('_form', [
        'model' => $model,
        'items'=>$items,
         'eitems'=>$eitems,
         'ledger_options'=>$ledger_options
    ]) ?>

</div>
