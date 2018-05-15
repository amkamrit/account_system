<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paynment".
 *
 * @property integer $ID
 * @property string $Payment_Method
 * @property integer $Amount
 * @property string $Cheque_Number
 * @property string $Image
 * @property string $Note
 */
class Paynment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paynment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name','Payment_Method', 'Amount', 'Cheque_Number', 'Image', 'Note'], 'required'],
            [['Amount'], 'integer'],
            [['Note'], 'string'],
            [['Payment_Method', 'Cheque_Number'], 'string', 'max' => 100],
            [['Image'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name'=>'Name',
            'Payment_Method' => 'Payment  Method',
            'Amount' => 'Amount',
            'Cheque_Number' => 'Cheque  Number',
            'Image' => 'Image',
            'Note' => 'Note',
        ];
    }
}
