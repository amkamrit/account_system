<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

?>
<div class="site-login">

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
                        <center><h1><?= Html::encode($this->title) ?></h1>

                        <h4><b>
                        <?php 
                        if(Yii::$app->Info->isSettingSet())
                        echo Yii::$app->Info->getClientFyStart().' to '.Yii::$app->Info->getClientFyEnd() 
                        ?>
                        </b></h4>
                        </center>
                        <hr>
                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            
                        ]); ?>

                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                            <?= $form->field($model, 'password')->passwordInput() ?>

                            <?= $form->field($model, 'rememberMe')->checkbox([
        
                            ]) ?>

                            <div class="form-group">                            
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                            </div>

                        <?php ActiveForm::end(); ?>

        </div>
        <div class="col-md-4"></div>
    </div>
</div>
