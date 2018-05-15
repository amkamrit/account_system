<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ALL ENTRIES';

?>
<div class="entries-index">

    <center><h1><b><?= Html::encode($this->title) ?></b></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create New Journal Entry', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    </center>
    <hr>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'number',
            [
                'attribute'=>'tag_id',
                'format'=>'raw',
                'value'=>function($data)
                        {
                            $tagText= $data->tag != null ? "<b>".$data->tag->title."</b>":NULL;
                            return $tagText;
                        }
            ],
            [
                'attribute'=>'entrytype_id',
                'value'=>function($data)
                        {

                            return $data->entrytype->name;
                        }
            ],
            [
                'attribute'=>'ledger',
                'format'=>'raw',
                'value'=>function($data)
                        {

                            return $data->getLedgerFormat();
                        }
            ],
            'date',
            'dr_total',
            'cr_total',
             ['class' => 'yii\grid\ActionColumn'],
            // 'narration',
        ],
    ]); ?>
</div>
