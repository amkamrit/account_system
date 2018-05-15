<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Accounts;
use app\models\Ledgers;


class AccountsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                
                'rules' => [
                   
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                     'delete' => ['POST'],
                     
                ],
            ],
        ];
       
    }

    public function actionIndex() 
    {
        $accountlist=new Accounts();
        $accountlist->only_opening = false;
        $accountlist->start_date = null;
        $accountlist->end_date = null;
        $accountlist->affects_gross = -1;
        $accountlist->start(0);

        $openingDifference=Ledgers::openingDiff();
        Yii::$app->view->title = 'LIST OF ACCOUNTS';
        return $this->render('index',['accountlist'=>$accountlist,'openingDifference'=>$openingDifference]);
    }



}
