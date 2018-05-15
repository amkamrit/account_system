<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
$this->title='Change Password';

?>


        <h2><center><b><?= strtoupper($this->title) ?></b></center></h2> <hr>
        <div class="col-md-4"></div>

        <div class="col-md-4">
                    <?php 
                        $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'enableClientValidation' => true,
                            'options' => [
                                'validateOnSubmit' => true,
                            ],
                        ]); 
                    ?>
                
                       
                       <div class="form-group has-feedback">
                            <?= $form -> field($model, 'oldpassword', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Old Password']]) -> label(false) -> passwordInput(); ?>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <?= $form -> field($model, 'newpassword', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'Password']]) -> label(false) -> passwordInput(); ?>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>

                       
                            
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Change Password</button>
                            
                        </div>

                    <?php ActiveForm::end(); ?>
            </div>

       
        
    </div>
</div>
