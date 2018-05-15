<?php
namespace app\helpers;

use Yii;
use yii\base\Component;
use yii\web\NotFoundHttpException;



class Init extends Component 
{
    public function init() 
    {	
       	if(Yii::$app->db->username != null)
        {
            
        }
        else if(Yii::$app->urlManager->parseRequest(Yii::$app->request)[0] == '/rest/create' || Yii::$app->urlManager->parseRequest(Yii::$app->request)[0] == 'rest/create')
        {

        }
        else if(Yii::$app->urlManager->parseRequest(Yii::$app->request)[0] == '/rest/connect' || Yii::$app->urlManager->parseRequest(Yii::$app->request)[0] == 'rest/connect')
        {}
        else
        {
        	if(Yii::$app->request->get('database') != null)
	    	{
	    		 	$session = Yii::$app->session;
			        if (!$session->isActive)
			        $session->open();
			        $session->set('username','root');
			        $session->set('host','localhost');
			        $session->set('password','root');
			        $session->set('dbname',Yii::$app->request->get('database'));
	    	}	
	    	else
	    	{
		    	echo Yii::$app->view->render('@app/helpers/initview/index',['url'=>Yii::$app->request->baseUrl]);
				exit;
	        }
        }

        parent::init();
    }
}

?>