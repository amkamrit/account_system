<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property string $id
 * @property string $date
 * @property int $level
 * @property string $host_ip
 * @property string $user
 * @property string $url
 * @property string $user_agent
 * @property string $message
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'level', 'host_ip', 'user', 'url', 'user_agent', 'message'], 'required'],
            [['date'], 'safe'],
            [['level'], 'integer'],
            [['host_ip', 'user'], 'string', 'max' => 25],
            [['url', 'message'], 'string', 'max' => 255],
            [['user_agent'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'level' => 'Level',
            'host_ip' => 'Host Ip',
            'user' => 'User',
            'url' => 'Url',
            'user_agent' => 'User Agent',
            'message' => 'Message',
        ];
    }
}
