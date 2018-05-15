<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Settings;

class InitialSetupController extends Controller
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
                        'actions' => ['index','update'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
        Initial Setup of Account
     */
    public function actionIndex()
    {
        $setting=Settings::findOne(1);
        if($setting == null)
        {
            $model = new Settings();
            if ($model->load(Yii::$app->request->post())) 
            {
                $model->code=strtolower($model->code);
                $model->id=1;
                if($model->save())
                {
                    Yii::$app->session->setFlash('success','Account Initialized');
                    return $this->redirect(['/site/index']);
                }
                else
                {
                    print_r($model->errors); exit;
                }
            } else {
                Yii::$app->view->title="INITIAL ACCOUNT SETUP";
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }


    /**
        Initial Setup of Account
     */
    public function actionUpdate()
    {
        $model=Settings::findOne(1);

           
            if ($model->load(Yii::$app->request->post())) 
            {
                $model->code=strtolower($model->code);
                if($model->save())
                {
                    Yii::$app->session->setFlash('success','Account Updated');
                    return $this->redirect(['/site/index']);
                }
                else
                {
                    print_r($model->errors); exit;
                }
            } 
            else 
            {
                Yii::$app->view->title="Update Account Info";
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        

    }

}
