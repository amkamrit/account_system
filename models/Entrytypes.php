<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entrytypes".
 *
 * @property string $id
 * @property string $label
 * @property string $name
 * @property string $description
 * @property int $base_type
 * @property int $numbering
 * @property string $prefix
 * @property string $suffix
 * @property int $zero_padding
 * @property int $restriction_bankcash
 *
 * @property Entries[] $entries
 */
class Entrytypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entrytypes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'name', 'description', 'prefix', 'suffix'], 'required'],
            [['base_type', 'numbering', 'zero_padding', 'restriction_bankcash'], 'integer'],
            [['label', 'name', 'description', 'prefix', 'suffix'], 'string', 'max' => 255],
            [['label'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'name' => 'Name',
            'description' => 'Description',
            'base_type' => 'Base Type',
            'numbering' => 'Numbering',
            'prefix' => 'Prefix',
            'suffix' => 'Suffix',
            'zero_padding' => 'Zero Padding',
            'restriction_bankcash' => 'Restriction Bankcash',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntries()
    {
        return $this->hasMany(Entries::className(), ['entrytype_id' => 'id']);
    }
}
