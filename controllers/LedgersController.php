<?php

namespace app\controllers;

use Yii;
use app\models\Ledgers;
use app\models\LedgersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\EntryItems;
use yii\filters\AccessControl;
use app\models\DateSearch;
use yii\web\Response;
use yii\web\ActiveForm;
use app\helpers\LedgerList;

/**
 * LedgersController implements the CRUD actions for Ledgers model.
 */
class LedgersController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                
                'rules' => [
                   
                    [
                        'actions' => ['ledgerstatement','index','view','create','update','delete','closingbalance','validate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                     
                     
                ],
            ],
        ];  
    }
   

    public function actionLedgerstatement($id,$export=null)
    {
        $dateSearch= new DateSearch();
        $start_date=null;
        $end_date=null;
        $ledger=Ledgers::findOne($id);
       Yii::$app->view->title = 'LEDGER STATEMENT FOR '.strtoupper('['.$ledger->code.'] '.$ledger->name).' FROM '.Yii::$app->Info->getClientFyStart(). ' TO '. Yii::$app->Info->getClientFyEnd();
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
                Yii::$app->view->title = 'LEDGER STATEMENT OF '.strtoupper($ledger->name).' FROM '.$start_date. ' TO '. $end_date;
            }          
        }


        $model=Yii::$app->Accounts->entryItems($id,$start_date,$end_date);

        //Exporting CSV FILE
        if($export != null && $export == 'csv')
        {
            $filename = 'Data-'.Date('Y-m-d:H-i-s').'-ledgerstatement.csv';
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=".$filename);
            echo $this->renderPartial('csv/ledgerstatement', [
                    'model' => $model,
                    'ledger'=>$ledger,
                    'search'=>$dateSearch
                ]);

        }
        else
        {
                 return $this->render('ledgerstatement', [
                    'model' => $model,
                    'ledger'=>$ledger,
                    'search'=>$dateSearch
                ]);
        }

    }

    /**
     * Lists all Ledgers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LedgersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ledgers model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Ledgers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ledgers();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if($model->op_balance == null || $model->op_balance == 0)
            {
                $model->op_balance_dc='';
            }
            if($model->save())
            {
                Yii::$app->session->setFlash('success','New Ledger Successfully Created');
                return $this->redirect(['/accounts', 'id' => $model->id]);
            }
            else
            print_r($model->errors); exit;
        } else {
             $ledgers = new LedgerList();
            $ledgers->start(null);
            $ledgers->buildList($ledgers, -1);
            return $this->render('create', [
                'model' => $model,
                'ledger_options' =>$ledgers->getList()
            ]);
        }
    }


    /**
     * Updates an existing Ledgers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if($model->op_balance == null || $model->op_balance == 0)
            {
                $model->op_balance_dc='';
            }
            if($model->save())
            {   
                Yii::$app->session->setFlash('success','Ledger Successfully Updated');
                return $this->redirect(['/accounts']);
            }
        } else {
              $ledgers = new LedgerList();
            $ledgers->start(null);
            $ledgers->buildList($ledgers, -1);
            return $this->render('update', [
                'model' => $model,
                'ledger_options' =>$ledgers->getList()
            ]);

        }
    }

    /**
     * Deletes an existing Ledgers model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        if($model->entryitems != null)
        {
            Yii::$app->session->setFlash('error','Please delete entries related to this ledger!!!');
            return $this->redirect(['/accounts']);
        }
        else
        {
            $ledger_name=$model->name;
            $model->delete();
            Yii::$app->session->setFlash('success','Ledger('.$ledger_name.') Succesfully Deleted!!!!');
            return $this->redirect(['/accounts']);
        }
        
    }

    /**
     * Finds the Ledgers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Ledgers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ledgers::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionClosingbalance($id)
    {

        $data=Yii::$app->Accounts->closingBalance($id,null,null);
        $string=Yii::$app->Accounts->convertDcPrefix($data['cl_total_dc'],$data['cl_total']);
        return json_encode($string);
    }
}
