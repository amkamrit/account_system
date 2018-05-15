<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Accounts;
use app\models\Ledgers;
use app\models\DateSearch;
use app\models\Entries;
use app\models\EntriesSearch;

class ReportsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                
                'rules' => [
                   
                    [
                        'actions' => ['index','trial-balance','profit-and-loss','balance-sheet','entries','export'],
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
        Yii::$app->view->title = 'Charts of Account';
        return $this->render('trialbalance',['accountlist'=>$accountlist,'openingDifference'=>$openingDifference]);
    }


    public function actionTrialBalance($export=null) 
    {
        Yii::$app->view->title = 'TRIAL BALANCE FROM '.Yii::$app->Info->getClientFyStart(). ' TO '. Yii::$app->Info->getClientFyEnd();

        $dateSearch= new DateSearch();
        $start_date=null;
        $end_date=null;

        //Loading Data if search is done.
        if($dateSearch->load(Yii::$app->request->post()))
        {
            $start_date=$dateSearch->start_date != null ? $dateSearch->start_date : null;
            $end_date=$dateSearch->end_date != null ? $dateSearch->end_date : null;  

            if($start_date == null || $end_date == null)
            {
                    $start_date=null;
                    $end_date=null;
            }
            else
            {
                Yii::$app->view->title = 'TRIAL BALANCE FROM '.$start_date.' TO '. $end_date;
            }          
        }

        $accountlist=new Accounts();
        $accountlist->only_opening = false;
        $accountlist->start_date = $start_date;
        $accountlist->end_date = $end_date;
        $accountlist->affects_gross = -1;
        $accountlist->start(0);

        $openingDifference=Ledgers::openingDiff();

        //Exporting CSV FILE
        if($export != null && $export == 'csv')
        {
            $filename = 'Data-'.Date('Y-m-d:H-i-s').'-trialbalance.csv';
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=".$filename);
            echo $this->renderPartial('csv/trialbalance',['accountlist'=>$accountlist,'openingDifference'=>$openingDifference]);

        }
        else
        {
            return $this->render('trialbalance',['accountlist'=>$accountlist,'openingDifference'=>$openingDifference,'search'=>$dateSearch]);
        }

    }


    public function actionProfitAndLoss($export=null)
    {

         Yii::$app->view->title = 'PROFIT & LOSS ACCOUNT FROM '.Yii::$app->Info->getClientFyStart(). ' TO '. Yii::$app->Info->getClientFyEnd();
        $dateSearch= new DateSearch();
        $start_date=null;
        $end_date=null;

        //Loading Data if search is done.
        if($dateSearch->load(Yii::$app->request->post()))
        {
            $start_date=$dateSearch->start_date != null ? $dateSearch->start_date : null;
            $end_date=$dateSearch->end_date != null ? $dateSearch->end_date : null;  

            if($start_date == null || $end_date == null)
            {
                    $start_date=null;
                    $end_date=null;
            }
            else
            {
                Yii::$app->view->title = 'PROFIT & LOSS ACCOUNT FROM '.$start_date.' TO '. $end_date;
            }          
        }

        $pal=Yii::$app->Accounts->profitAndLossCalculation($start_date,$end_date);


        //Exporting CSV FILE
        if($export != null && $export == 'csv')
        {
            $filename = 'Data-'.Date('Y-m-d:H-i-s').'-profitandloss.csv';
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=".$filename);
           return $this->renderPartial('csv/profitandloss',['pal'=>$pal]);

        }
        else
        {
            return $this->render('profitandloss',['pal'=>$pal,'search'=>$dateSearch]);
        }
    }

    public function actionBalanceSheet($export=null)
    {
        Yii::$app->view->title = 'BALANCE SHEET FROM '.Yii::$app->Info->getClientFyStart(). ' TO '. Yii::$app->Info->getClientFyEnd();
        $dateSearch= new DateSearch();
        $start_date=null;
        $end_date=null;

        //Loading Data if search is done.
        if($dateSearch->load(Yii::$app->request->post()))
        {
            $start_date=$dateSearch->start_date != null ? $dateSearch->start_date : null;
            $end_date=$dateSearch->end_date != null ? $dateSearch->end_date : null;  

            if($start_date == null || $end_date == null)
            {
                    $start_date=null;
                    $end_date=null;
            }
            else
            {
                Yii::$app->view->title = 'BALANCE SHEET FROM '.$start_date.' TO '. $end_date;
            }          
        }


        $pal=Yii::$app->Accounts->profitAndLossCalculation($start_date,$end_date);
        $bs['pl']['amount']=$pal['netData']['amount'];
        $bs['pl']['amount_dc']=$pal['netData']['amount_dc'];

        /* Liabilities */
        $liabilities = new Accounts();
        $liabilities->only_opening = false;
        $liabilities->start_date = $start_date;
        $liabilities->end_date = $end_date;
        $liabilities->affects_gross = -1;
        $liabilities->start(2);

        $bs['liabilities'] = $liabilities;

        $bs['liabilities_total'] = 0;
        $bs['liabilities_total'] = $liabilities->cl_total;
        $bs['liabilities_total_dc'] = $liabilities->cl_total_dc;
     

        /* Assets */
        $assets = new Accounts();
        $assets->only_opening = false;
        $assets->start_date = $start_date;
        $assets->end_date = $end_date;
        $assets->affects_gross = -1;
        $assets->start(1);

        $bs['assets'] = $assets;

        $bs['assets_total'] = 0;
        $bs['assets_total'] = $assets->cl_total;
        $bs['assets_total_dc'] = $assets->cl_total_dc;

        if($bs['liabilities_total'] == 0)  $bs['liabilities_total_dc']='C';
        if($bs['assets_total'] == 0)  $bs['assets_total_dc']='D';  

        //Getting O/P Balance
        if($bs['pl']['amount_dc'] == 'C')
        {
            //Calculating liabilities after p/l in case liabilities is in Dr.
            $temp_liabilities=Yii::$app->Accounts->currentClosingBalance($bs['pl']['amount'],$bs['pl']['amount_dc'],$bs['liabilities_total'],$bs['liabilities_total_dc']);

             $bs['op']=Yii::$app->Accounts->currentClosingBalance($bs['assets_total'],$bs['assets_total_dc'],$temp_liabilities['amount'],$temp_liabilities['amount_dc']);
        }
        else
        {
             //Calculating assets after p/l in case liabilities is in Cr.
            $temp_assets=Yii::$app->Accounts->currentClosingBalance($bs['pl']['amount'],$bs['pl']['amount_dc'],$bs['assets_total'],$bs['assets_total_dc']);

             $bs['op']=Yii::$app->Accounts->currentClosingBalance($temp_assets['amount'],$temp_assets['amount_dc'], $bs['liabilities_total'], $bs['liabilities_total_dc']); 
        }

        $openingDifference=Ledgers::openingDiff();




         //Exporting CSV FILE
        if($export != null && $export == 'csv')
        {
            $filename = 'Data-'.Date('Y-m-d:H-i-s').'-balancesheet.csv';
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=".$filename);
            return $this->renderPartial('csv/balancesheet',['bs'=>$bs,'openingDifference'=>$openingDifference]);

        }
        else
        {
            return $this->render('balancesheet',['bs'=>$bs,'openingDifference'=>$openingDifference,'search'=>$dateSearch]);
        }

    }

    public function actionExport()
    {

         $filename = 'Data-'.Date('YmdGis').'-export.csv';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$filename);

       Yii::$app->view->title = 'PROFIT & LOSS ACCOUNT FROM '.Yii::$app->Info->getClientFyStart(). ' TO '. Yii::$app->Info->getClientFyEnd();
        $dateSearch= new DateSearch();
        $start_date=null;
        $end_date=null;

        //Loading Data if search is done.
        if($dateSearch->load(Yii::$app->request->post()))
        {
            $start_date=$dateSearch->start_date != null ? $dateSearch->start_date : null;
            $end_date=$dateSearch->end_date != null ? $dateSearch->end_date : null;  

            if($start_date == null || $end_date == null)
            {
                    $start_date=null;
                    $end_date=null;
            }
            else
            {
                Yii::$app->view->title = 'PROFIT & LOSS ACCOUNT FROM '.$start_date.' TO '. $end_date;
            }          
        }

        $pal=Yii::$app->Accounts->profitAndLossCalculation($start_date,$end_date);
       echo $this->renderPartial('csv/profitandloss',['pal'=>$pal]);

       //return $this->renderPartial('csv/trialbalance',['accountlist'=>$accountlist,'openingDifference'=>$openingDifference]);
    }


    public function actionEntries()
    {
        Yii::$app->view->title = 'VOUCHER DETAILS FROM '.Yii::$app->Info->getClientFyStart(). ' TO '. Yii::$app->Info->getClientFyEnd();

        $dateSearch= new DateSearch();
        $start_date=null;
        $end_date=null;

        //Loading Data if search is done.
        if($dateSearch->load(Yii::$app->request->post()))
        {
            $start_date=$dateSearch->start_date != null ? $dateSearch->start_date : null;
            $end_date=$dateSearch->end_date != null ? $dateSearch->end_date : null;  

            if($start_date == null || $end_date == null)
            {
                    $start_date=null;
                    $end_date=null;

            }
            else
            {
                Yii::$app->view->title = 'VOUCHER DETAILS FROM '.$start_date.' TO '. $end_date;
            }          
        }

      /*  $searchModel = new EntriesSearch();
        $dataProvider = $searchModel->searchDate(Yii::$app->request->queryParams,$start_date,$end_date);

        return $this->render('entries', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'search'=>$dateSearch
        ]);*/

        if($start_date != null && $end_date != null)
            $entries=Entries::find()->where('date >=:sdate AND entries.date <=:edate ORDER BY date ASC',[':sdate'=>$start_date,':edate'=>$end_date])->all();
        else
            $entries=Entries::find()->orderBy(['date'=>'ASC'])->all();

         return $this->render('entries', [
            'entries'=>$entries,
            'search'=>$dateSearch
        ]);

        


    }



}
