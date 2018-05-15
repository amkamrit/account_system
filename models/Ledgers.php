<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ledgers".
 *
 * @property string $id
 * @property string $group_id
 * @property string $name
 * @property string $code
 * @property string $op_balance
 * @property string $op_balance_dc
 * @property int $type
 * @property int $reconciliation
 * @property string $notes
 *
 * @property Entryitems[] $entryitems
 * @property Groups $group
 */
class Ledgers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ledgers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['group_id', 'name'], 'required'],
            [['group_id', 'type', 'reconciliation','created_by'], 'integer'],
            [['op_balance'], 'number'],
            [['name', 'code'], 'string', 'max' => 255],
            [['op_balance_dc'], 'string', 'max' => 1],
            [['notes'], 'string', 'max' => 500],
            [['name'], 'unique', 'targetClass' => '\app\models\Ledgers', 'message' => 'This ledger name has already been taken.'],
            [['code'], 'unique'],
            ['op_balance','default','value'=>0.00],
            ['code','default','value'=>NULL],
             ['created_by', 'default', 'value' => Yii::$app->user->identity->id],
            [['group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['group_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_id' => 'Group',
            'name' => 'Name',
            'code' => 'Code',
            'op_balance' => 'Op Balance',
            'op_balance_dc' => 'Op Balance Dc',
            'type' => 'Type',
            'reconciliation' => 'Reconciliation',
            'notes' => 'Notes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntryitems()
    {
        return $this->hasMany(Entryitems::className(), ['ledger_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(Groups::className(), ['id' => 'group_id']);
    }

    public static function openingDiff()
    {
        $model=Ledgers::find()->all();
        $debit_total=0;
        $credit_total=0;

        foreach($model as $key => $value) 
        {
              if($value->op_balance_dc == 'D')
              {
                $debit_total += $value->op_balance;
              }
              elseif ($value->op_balance_dc == 'C') 
              {
                 $credit_total += $value->op_balance;
              }
        }

        return Yii::$app->Accounts->currentClosingBalance(
                $debit_total,
                'D',
                $credit_total,
                'C'
                );

    }
}
