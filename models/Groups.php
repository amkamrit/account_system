<?php
namespace app\models;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $name
 * @property string $code
 * @property int $affects_gross
 *
 * @property Groups $parent
 * @property Groups[] $groups
 * @property Ledgers[] $ledgers
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'affects_gross','created_by'], 'integer'],
            [['name','parent_id'], 'required'],
            [['name', 'code'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
             ['created_by', 'default', 'value' => Yii::$app->user->identity->id],
            ['code', 'default', 'value' => NULL],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent Group',
            'name' => 'Name',
            'code' => 'Code',
            'affects_gross' => 'Affects Gross',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Groups::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroups()
    {
        return $this->hasMany(Groups::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedgers()
    {
        return $this->hasMany(Ledgers::className(), ['group_id' => 'id']);
    }
}
