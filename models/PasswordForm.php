<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;


/**
 * Password form
 */
class PasswordForm extends Model
{
    public $oldpassword;
    public $newpassword;
   


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['oldpassword', 'required'],
            ['oldpassword', 'string'],

            ['newpassword', 'required'],
            ['newpassword', 'string', 'min' => 6, 'max' => 255],
        ];
    }

    

    public function changePassword()
    {
       $user= User::findIdentity(Yii::$app->user->id);
    
                if($user->validatePassword($this->oldpassword))
                {
                        $user->setPassword($this->newpassword);
                        if ($user->update())
                        {
                            return $user;
                        }
                }
                else
                {
                    //
                    return false;
                }
    }



}
