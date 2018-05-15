<?php

namespace app\controllers;

use Yii;
use app\models\Entries;
use app\models\EntriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Entryitems;
use app\helpers\EntriesHelper;
use app\helpers\InfoHelper;
use yii\filters\AccessControl;
use app\helpers\LedgerList;

/**
 * EntriesController implements the CRUD actions for Entries model.
 */
class EntriesController extends Controller
{
    /**
     * @inheritdoc
     */
   public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                
                'rules' => [
                   
                    [
                        'actions' => ['index','view','create','update','delete','create-second','add-row'],
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
    /**
     * Lists all Entries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Entries model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=$this->findModel($id);
        $items=$model->entryitems;
        return $this->render('view', [
            'model' => $model,
            'items'=>$items

        ]);
    }


    public function actionAddRow($id)
    {
        $ledgers = new LedgerList();
        $ledgers->start(null);
        $ledgers->buildList($ledgers, -1);

        return $this->renderPartial('addrow',['key'=>$id,'ledger_options'=>$ledgers->getList()]);
    }
    /**
     * Creates a new Entries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Entries();
        $items=new Entryitems();
       
        for ($x = 0; $x <= 30; $x++) 
        {
            $eitems[$x]=new Entryitems();
        }

        if ($model->load(Yii::$app->request->post())) 
        { 
            //Check for date
            if(EntriesHelper::checkFinancialYearDate($model->date))
            {
               Yii::$app->session->setFlash("error","Entered Date is not between financial year date");
                return $this->redirect(['create']); 
            }
            //Saving Entries
            $model->dr_total=EntriesHelper::calculateDrTotal();
            $model->cr_total=EntriesHelper::calculateCrTotal();
            if($model->dr_total != $model->cr_total)
            {
                //Setting Error Message
                Yii::$app->session->setFlash("error","Debit Total And Credit Total Are not equal");
                return $this->redirect(['create']);
            }
            $model->entrytype_id=Yii::$app->Info->getEntryTypeId();
            if($model->save())
            {
                //Loading Multiple EntryItems Model at once.
                if(Entryitems::loadMultiple($eitems, Yii::$app->request->post()))
                {
                    foreach ($eitems as $key => $value) 
                    {
                        if($value->ledger_id != null)
                        {
                                $value->entry_id=$model->id;
                                if($value->dc == "D")$value->amount=$value->dr_amount != null ? $value->dr_amount:0;
                                else$value->amount=$value->cr_amount != null ?$value->cr_amount:0;
                                if(!$value->save())
                                {
                                    $error_array[]=true;   
                                }
                        }
                    }
                }

               /* $i=0;
                foreach (Yii::$app->request->post('Entryitems')['ledger_id'] as $key => $value) 
                {
                    $entryitems=new Entryitems();
                    if($value != null)
                    {
                        $entryitems->entry_id=$model->id;
                        $entryitems->ledger_id=$value;
                        $entryitems->dc=Yii::$app->request->post('Entryitems')['dc'][$key];
                        if($entryitems->dc == "D")$entryitems->amount=Yii::$app->request->post('Entryitems')['dr_amount'][$key];
                        else$entryitems->amount=Yii::$app->request->post('Entryitems')['cr_amount'][$key];
                        if(!$entryitems->save())
                        {
                            $error_array[]=true;
                        }

                    }

                        
                }*/

            }
            else
            {
                print_r($model->errors);exit;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {

        $ledgers = new LedgerList();
        $ledgers->start(null);
        $ledgers->buildList($ledgers, -1);

            return $this->render('create', [
                'model' => $model,
                'items'=>$items,
                'eitems'=>$eitems,
                'ledger_options'=>$ledgers->getList()
            ]);
        }
    }

    public function actionCreateTestingOnly()
    {
        $model = new Entries();
        $items=new Entryitems();
       
        for ($x = 0; $x <= 20; $x++) 
        {
            $eitems[$x]=new Entryitems();
        }

        if ($model->load(Yii::$app->request->post())) 
        { 
            //Check for date
            if(EntriesHelper::checkFinancialYearDate($model->date))
            {
               Yii::$app->session->setFlash("error","Entered Date is not between financial year date");
                return $this->redirect(['create']); 
            }
            //Saving Entries
            $model->dr_total=EntriesHelper::calculateDrTotal();
            $model->cr_total=EntriesHelper::calculateCrTotal();
            if($model->dr_total != $model->cr_total)
            {
                //Setting Error Message
                Yii::$app->session->setFlash("error","Debit Total And Credit Total Are not equal");
                return $this->redirect(['create']);
            }
            $model->entrytype_id=Yii::$app->Info->getEntryTypeId();
            if($model->save())
            {
                //Loading Multiple EntryItems Model at once.
                if(Entryitems::loadMultiple($eitems, Yii::$app->request->post()))
                {
                    foreach ($eitems as $key => $value) 
                    {
                        if($value->ledger_id != null)
                        {
                                $value->entry_id=$model->id;
                                if($value->dc == "D")$value->amount=$value->dr_amount;
                                else$value->amount=$value->cr_amount;
                                if(!$value->save())
                                {
                                    $error_array[]=true;   
                                }
                        }
                    }
                }

               /* $i=0;
                foreach (Yii::$app->request->post('Entryitems')['ledger_id'] as $key => $value) 
                {
                    $entryitems=new Entryitems();
                    if($value != null)
                    {
                        $entryitems->entry_id=$model->id;
                        $entryitems->ledger_id=$value;
                        $entryitems->dc=Yii::$app->request->post('Entryitems')['dc'][$key];
                        if($entryitems->dc == "D")$entryitems->amount=Yii::$app->request->post('Entryitems')['dr_amount'][$key];
                        else$entryitems->amount=Yii::$app->request->post('Entryitems')['cr_amount'][$key];
                        if(!$entryitems->save())
                        {
                            $error_array[]=true;
                        }

                    }

                        
                }*/

            }
            else
            {
                print_r($model->errors);exit;
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {

        $ledgers = new LedgerList();
        $ledgers->start(null);
        $ledgers->buildList($ledgers, -1);

            return $this->render('create', [
                'model' => $model,
                'items'=>$items,
                'eitems'=>$eitems,
                'ledger_options'=>$ledgers->getList()
            ]);
        }
    }
    /**
     * Updates an existing Entries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $error_array=array();
        $items=Entryitems::find()->where('entry_id=:id',[':id'=>$id])->all();
        $item=new Entryitems();
        foreach ($items as $key => $value) 
        {
            if($value->dc == 'D') $value->dr_amount = $value->amount;
            else $value->cr_amount = $value->amount;
            $eitems[$key]=$value;
        }

        if ($model->load(Yii::$app->request->post())) 
        { 

            //Check for date
            if(EntriesHelper::checkFinancialYearDate($model->date))
            {
               Yii::$app->session->setFlash("error","Entered Date is not between financial year date");
                return $this->redirect(['/entries/update/'.$id]); 
            }
            //Saving Entries
            $model->dr_total=EntriesHelper::calculateDrTotal();
            $model->cr_total=EntriesHelper::calculateCrTotal();
            if($model->dr_total != $model->cr_total)
            {
                //Setting Error Message
                Yii::$app->session->setFlash("error","Debit Total And Credit Total Are not equal");
                return $this->redirect(['create']);
            }
            $model->entrytype_id=Yii::$app->Info->getEntryTypeId();
            $transaction = Yii::$app->db->beginTransaction();
            if($model->save())
            {
                for ($x = 0; $x <= 30; $x++) 
                {
                    $uitems[$x]=new Entryitems();
                }
                //Loading Multiple EntryItems Model at once.
                if(Entryitems::loadMultiple($uitems, Yii::$app->request->post()))
                {
                    foreach ($eitems as $key => $value) 
                    {
                        if(!$value->delete())
                        {
                            $error_array[]=true;
                        }
                    }
                    foreach ($uitems as $key => $value) 
                    {
                        if($value->ledger_id != null)
                        {
                                $value->entry_id=$model->id;
                                if($value->dc == "D")$value->amount=$value->dr_amount;
                                else$value->amount=$value->cr_amount;
                                if(!$value->save())
                                {
                                    $error_array[]=true;   
                                }
                        }
                    }
                }

            }
            else
            {
                print_r($model->errors);exit;
            }

            if(in_array(true, $error_array))
            {
                $transaction->rollBack();
            }
            else
            {
                $transaction->commit();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } 
        else {
            $ledgers = new LedgerList();
            $ledgers->start(null);
            $ledgers->buildList($ledgers, -1);
            return $this->render('update_form2', [
                'model' => $model,
                'eitems'=>$eitems,
                'item'=>$item,
                'ledger_options'=>$ledgers->getList()
            ]);
        }
    }

    /**
     * Deletes an existing Entries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model=$this->findModel($id);
        $entryItems=$model->entryitems;
        if($entryItems != null)
        {
            //Begin Transaction
            $transaction=Yii::$app->db->beginTransaction();
            foreach ($entryItems as $key => $value) 
            {
                if($value->delete())
                    $error_array[]=false; 
                else
                    $error_array[]=true; 
            }

            if(!$model->delete())
            {
                $error_array[]=true;
            }

            if(in_array(true, $error_array))
            {
                $transaction->rollback();
                Yii::$app->session->setFlash('error','Error in Entry Deletion');
            }
            else
            {
                $transaction->commit();
                Yii::$app->session->setFlash('success','Entry Successfully Deleted');
            }

        }
        else
        {
            $transaction=Yii::$app->db->beginTransaction();
            if($model->delete())
            {
                 $transaction->commit();
            }
            Yii::$app->session->setFlash('success','Entry Successfully Deleted');
        }


      
        return $this->redirect(['index']);
    }

    /**
     * Finds the Entries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Entries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Entries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

 
}
