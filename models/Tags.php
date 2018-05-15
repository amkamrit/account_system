<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property string $id
 * @property string $title
 * @property string $color
 * @property string $background
 *
 * @property Entries[] $entries
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['color', 'background'], 'string', 'max' => 6],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'color' => 'Color',
            'background' => 'Background',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
                $this->title=strtoupper($this->title);
                return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntries()
    {
        return $this->hasMany(Entries::className(), ['tag_id' => 'id']);
    }
}
