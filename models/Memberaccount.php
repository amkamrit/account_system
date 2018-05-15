<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "memberaccount".
 *
 * @property integer $Sn
 * @property string $Name
 * @property string $Product_Name
 * @property integer $Size
 * @property integer $Weight
 * @property integer $Price
 * @property integer $Quantity
 * @property integer $Dr_Amount
 * @property integer $Cr_Amount
 * @property string $Note
 */
class Memberaccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'memberaccount';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Product_Name', 'Size', 'Weight', 'Price', 'Quantity', 'Dr_Amount', 'Cr_Amount', 'Note'], 'required'],
            [['Size', 'Weight', 'Price', 'Quantity', 'Dr_Amount', 'Cr_Amount'], 'integer'],
            [['Note'], 'string'],
            [['Name', 'Product_Name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Sn' => 'Sn',
            'Name' => 'Name',
            'Product_Name' => 'Product  Name',
            'Size' => 'Size',
            'Weight' => 'Weight',
            'Price' => 'Price',
            'Quantity' => 'Quantity',
            'Dr_Amount' => 'Dr  Amount',
            'Cr_Amount' => 'Cr  Amount',
            'Note' => 'Note',
        ];
    }
}
