<?php

namespace app\controllers;

use Yii;
use app\models\Groups;
use app\models\Ledgers;
use app\models\GroupsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\CarryForward;
use app\models\Settings;


/**
 * GroupsController implements the CRUD actions for Groups model.
 */
class CarryForwardController extends Controller
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
                        'actions' => ['index','carry-account-to-next-year'],
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
        return $this->render('index');
    }


    public function actionCarryAccountToNextYear()
    {
        $carryForward= new CarryForward();
        $setting=Settings::findOne(1);
        $host=$db_name=$db_username=$db_password=$fy_start=$fy_end=null;
        //Loading Data 
        if($carryForward->load(Yii::$app->request->post()))
        {
            $host=$carryForward->host;
            $db_name=$carryForward->database_name;
            $db_username=$carryForward->database_username;
            $db_password=$carryForward->database_password;

            $fy_start=$carryForward->fy_start;
            $fy_end=$carryForward->fy_end;
        }

        $ledgers=Ledgers::find()->all();
        $allgroups=Groups::find()->all();
        $connection = new \yii\db\Connection([
        'dsn' => 'mysql:host='.$host.';dbname='.$setting->code.'_'.$db_name,
        'username' => $db_username,
        'password' => $db_password,
        ]);
        
       
        $connection->open();
      
        $transaction = $connection->beginTransaction();

        foreach ($allgroups as $key => $value) 
        {
            $id=$value->id;
            $parent_id=$value->parent_id;
            $name=$value->name;
            $code=$value->code != null ? "'$value->code'":"NULL";
            $affect_gross=$value->affects_gross;
            $created_at=$value->created_at;
            $created_by=$value->created_by;
            

            if($id != 1 && $id != 2 && $id != 3 && $id != 4)
            {
               
                        try
                        {
                            $command = $connection->createCommand("INSERT INTO groups (id,parent_id, name, code,affects_gross,created_at,created_by) VALUES ('$id','$parent_id','$name',$code,'$affect_gross','$created_at','$created_by')"); 
                            $command->execute();

                            $error_array[]=false;
                        }
                        catch(Exception $e)
                        {
                            $error_array[]=true;

                        }
            }
        }

        foreach ($ledgers as $key => $value) 
        {
            $id=$value->id;
            $group_id=$value->group_id;
            $name=$value->name;
            $code=$value->code != null ? "'$value->code'":"NULL";
            $op_balance=0.00;
            $op_balance_dc=$value->op_balance_dc;
            $type=$value->type;
            $reconciliation=$value->reconciliation;
            $notes=$value->notes;

            $superParentId=Yii::$app->Accounts->superParentId($value);
            if($superParentId == 1 || $superParentId == 2)
            {
                //Setting OP if assets or liabilities.
                $op_balance=Yii::$app->Accounts->closingBalance($value->id,null,null)['cl_total'];
                $op_balance_dc=Yii::$app->Accounts->closingBalance($value->id,null,null)['cl_total_dc'];
            }    

            try
            {
                $command = $connection->createCommand("INSERT INTO ledgers (id,group_id, name, code,op_balance,op_balance_dc,type,reconciliation,notes) VALUES ('$id','$group_id','$name',$code,'$op_balance','$op_balance_dc','$type','$reconciliation','$notes')"); 
                $command->execute();

                $error_array[]=false;
            }
            catch(Exception $e)
            {
                $error_array[]=true;

            }
        }




        /**
            THis loc does not work. Work on it Later.
        */
        if(in_array(true, $error_array))
        {
            $transaction->rollBack();
        }
        else
        {
            $transaction->commit();
        }

        //Inserting into setting table
         try
            {
                $id=$setting->id;
                $name=$setting->name;
                $code=$setting->code;
                $address=$setting->address;
                $email=$setting->email;
                $contact_no=$setting->contact_no;
                $description=$setting->description != null ? "'$setting->description'":"NULL";

                $command = $connection->createCommand("INSERT INTO settings (id, name, code,address,email,contact_no,description,fy_start,fy_end) VALUES ('$id','$name','$code','$address','$email','$contact_no',$description,'$fy_start','$fy_end')"); 
                $command->execute();

                $error_array[]=false;
            }
            catch(Exception $e)
            {
                $error_array[]=true;
            }


        Yii::$app->session->setFlash('success','Account Carried Forwarded');
        echo $this->render('index');
    }

  
}
