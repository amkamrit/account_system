<?php
namespace app\models;

use Yii;
use yii\base\Model;


class DateSearch extends Model
{
   
public $start_date;
public $end_date;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_date', 'end_date'], 'safe'],
            [['start_date','end_date'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'start_date'=> 'Start Date (YYYY-MM-DD)',
            'end_date' => 'End Date (YYYY-MM-DD)',
        ];
    }


}
