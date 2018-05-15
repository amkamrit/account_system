<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Settings;
use app\models\Accounts;
use app\models\SignupForm;
use app\models\PasswordForm;
use app\models\Memberaccount;

class SiteController extends Controller
{


    public function beforeAction($event)
    {
       if(Yii::$app->db->isActive)
       { 
            if (!Yii::$app->user->isGuest) 
            {
                if(Yii::$app->db->username != null)
                {
                    if(!Yii::$app->Info->isSettingSet()) return $this->redirect(array('/initial-setup/index'));
                }
                    
            }
        }
        return parent::beforeAction($event);
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout','index'],
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($database=null)
    {

        if(Yii::$app->request->get('database') != null)
        {  
            return $this->redirect('index');
        }   
       
        if (Yii::$app->user->isGuest)return $this->redirect(['login']);


          /* Liabilities */
        $liabilities = new Accounts();
        $liabilities->only_opening = false;
        $liabilities->start_date = null;
        $liabilities->end_date = null;
        $liabilities->affects_gross = -1;
        $liabilities->start(2);

        $bs['liabilities'] = $liabilities;

        $bs['liabilities_total'] = 0;
        $bs['liabilities_total'] = $liabilities->cl_total;
        $bs['liabilities_total_dc'] = $liabilities->cl_total_dc;
     

        /* Assets */
        $assets = new Accounts();
        $assets->only_opening = false;
        $assets->start_date = null;
        $assets->end_date = null;
        $assets->affects_gross = -1;
        $assets->start(1);

        $bs['assets'] = $assets;
        $bs['assets_total'] = 0;
        $bs['assets_total'] = $assets->cl_total;
        $bs['assets_total_dc'] = $assets->cl_total_dc;


         /* Incomes */
        $incomes = new Accounts();
        $incomes->only_opening = false;
        $incomes->start_date = null;
        $incomes->end_date = null;
        $incomes->affects_gross = -1;
        $incomes->start(3);

        $bs['incomes'] = $incomes;
        $bs['incomes_total'] = 0;
        $bs['incomes_total'] = $incomes->cl_total;
        $bs['incomes_total_dc'] = $incomes->cl_total_dc;

        /* Expenses */
        $expenses = new Accounts();
        $expenses->only_opening = false;
        $expenses->start_date = null;
        $expenses->end_date = null;
        $expenses->affects_gross = -1;
        $expenses->start(4);

        $bs['expenses'] = $expenses;
        $bs['expenses_total'] = 0;
        $bs['expenses_total'] = $expenses->cl_total;
        $bs['expenses_total_dc'] = $expenses->cl_total_dc;


        return $this->render('index',['bs'=>$bs]);
    }
public function actionMemberinfo()
    {
       $memberaccount=Memberaccount::find()->all();

          return $this->render('Memberinfo', [
            'memberAccount' => $memberaccount,
            ]);
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {
            if(!Yii::$app->Info->isSettingSet()) return $this->redirect(array('/initial-setup/index'));
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

     /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {   
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) 
        {
          if($model->email == null || $model->email=='')
          {
             $model->email=$model->username."@".$model->username.".com";
          }
          if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) 
                {
                    if(!Yii::$app->Info->isSettingSet()) return $this->redirect(array('/initial-setup/index'));
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSetting()
    {
        return $this->render('settings');
    }

    public function actionChangePassword()
    {
            $model=new PasswordForm();
            if ($model->load(Yii::$app->request->post())) 
            {
                if($model->changePassword())
                {
                     Yii::$app->getSession()->setFlash('success', 'Your Password has been changed');
                    return $this->render('change-password',['model'=>$model]);
                }
                else
                {
                    Yii::$app->getSession()->setFlash('error', 'Old Password does not Match');
                    return $this->render('change-password',['model'=>$model]);
                } 
            }
            return $this->render('change-password', [
                'model' => $model,
            ]);
    }

    
}
