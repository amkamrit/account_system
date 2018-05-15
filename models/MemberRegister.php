<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "memberregister".
 *
 * @property integer $Sn
 * @property string $Name
 * @property string $Address
 * @property string $Code
 * @property string $Company_Name
 */
class Memberregister extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'memberregister';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'Address', 'Code', 'Company_Name'], 'required'],
            [['Name', 'Address', 'Code', 'Company_Name'], 'string', 'max' => 100],
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
            'Address' => 'Address',
            'Code' => 'Code',
            'Company_Name' => 'Company  Name',
        ];
    }
}
