<?php
namespace app\models;

use Yii;
use yii\base\Model;


class AccountsDatabases extends \yii\db\ActiveRecord
{

public static function getDb() {
    return Yii::$app->get('db2'); // new database
}

  public static function tableName()
    {
        return 'info';
    }
    


}
