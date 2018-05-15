<?php
namespace app\models;

use Yii;
use yii\base\Model;


class CarryForward extends Model
{

public $host;
public $database_name;
public $database_password;
public $database_username;

public $fy_start;
public $fy_end;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['host', 'database_name','database_password','database_username','fy_start','fy_end'], 'safe'],
            [['host', 'database_name','database_username','fy_start','fy_end'], 'required'],
          
        ];
    }

     public function attributeLabels()
    {
        return [
            'fy_start'=> 'Financial Year Start (YYYY-MM-DD)',
            'fy_end' => 'Financial Year End (YYYY-MM-DD)',
        ];
    }


    


}
