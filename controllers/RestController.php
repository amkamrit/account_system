<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Entries;
use app\models\Entryitems;
use app\models\Ledgers;
use app\helpers\EntriesHelper;
use app\models\AccountsDatabases;

class RestController extends ActiveController
{
	 public $modelClass = 'common\models\Entries';


	 public function actions()
	 {
	 	$actions=parent::actions();
	 	 unset($actions['create'],$actions['update'],$actions['index']);
	 	return $actions;
	 }


    protected function verbs()
    {
        return [
            'create'=>['POST'],
        ];

    }
    public function actionConnect()
    {

        $session = Yii::$app->session;
        if (!$session->isActive)
        $session->open();
        $database=AccountsDatabases::find()->where(['status'=>'active'])->one();
        $session->set('username','root');
        $session->set('host','localhost');
        $session->set('password','');
        $session->set('dbname','tss_2074/75');
        $error['success']=1;
        return $error;
    }

	public function actionCreate()
    {
    	$error=array();
    	/*$error['success']=0;
        $error['message']=$message;
        return  $error;*/
    	$model=new Entries;
    	
    	$transaction = Yii::$app->db->beginTransaction();

    	$model->narration=Yii::$app->request->post('narration');
    	$model->date=Yii::$app->request->post('date');
    	//$model->created_by=2;
    	if(EntriesHelper::checkFinancialYearDate($model->date))
        {
            $error['success']=0;
	        $error['message']="Date not between financial year";
	        return  $error;
        }
         //Saving Entries
        $model->dr_total=EntriesHelper::calculateDrTotal();
        $model->cr_total=EntriesHelper::calculateCrTotal();
        $model->entrytype_id=Yii::$app->Info->getEntryTypeId();
        //$model->created_by=3;
        if($model->dr_total != $model->cr_total)
        {
            $error['success']=0;
	        $error['message']="Amount not equal";
	        return  $error;
        }
        	$error_array=array();
         if($model->save())
            {
        		//return Yii::$app->request->post('Entryitems');
                 foreach (Yii::$app->request->post('Entryitems') as $key => $value) 
        			{
        				$items=new EntryItems;
                        if($value['ledger_id'] != null)
                        {
                                $items->entry_id=$model->id;
                                if(Ledgers::findOne($value['ledger_id']) == null)
                                {
                                	 	$error['success']=0;
								        $error['message']="No Ledger Found";
								        return  $error;
                                }
                                $items->ledger_id=$value['ledger_id'];
                                $items->dc=$value['dc'];
                                if($value['dc'] == "D")$items->amount=$value['dr_amount'];
                                else$items->amount=$value['cr_amount'];
                                if(!$items->save())
                                {
                                	$error['message']=$items->errors;
	        						return  $error;
                                    $error_array[]=true;   
                                }
                        }
                   }
	                
            }
            else
            {
            	$error['success']=0;
		        $error['message']=$model->errors;
		        return  $error;
            }

            if(in_array('true', $error_array))
            	 $transaction->rollBack();
            else
            	 $transaction->commit();

            	$error['success']=1;
		        $error['message']="Data Saved";
		        return  $error;

    }
   
}
