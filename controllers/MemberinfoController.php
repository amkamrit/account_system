<?php

namespace backend\controllers;

use yii\web\Controller;
use backend\models\Memberinfo;

class Memberinfo extends Controller
{
    public function actionIndex()
    {
        $object = menberinfo::findOne(1);
        return $this->render('index', [
            'object' => $object,
        ]);
    }
}
