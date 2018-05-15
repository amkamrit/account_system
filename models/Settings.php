<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $address
 * @property string $email
 * @property string $fy_start
 * @property string $fy_end
 * @property string $description
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'code', 'address', 'email', 'fy_start', 'fy_end','contact_no'], 'required'],
            [['id'], 'integer'],
            [['description','contact_no'], 'string'],
            [['name', 'address'], 'string', 'max' => 255],
            [['email'], 'email'], 
            [['code'], 'string', 'max' => 22],
            [['fy_start', 'fy_end'], 'string', 'max' => 30],
            [['id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'School Name',
            'code' => 'Code (Database Prefix)',
            'address' => 'Address',
            'email' => 'Email',
            'fy_start' => 'Financial Year Start(YYYYY-MM-DD)',
            'fy_end' => 'Financial Year End(YYYYY-MM-DD)',
            'description' => 'Description',
        ];
    }
}
