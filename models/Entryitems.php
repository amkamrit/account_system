<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entryitems".
 *
 * @property string $id
 * @property string $entry_id
 * @property string $ledger_id
 * @property string $amount
 * @property string $dc
 * @property string $reconciliation_date
 *
 * @property Entries $entry
 * @property Ledgers $ledger
 */
class Entryitems extends \yii\db\ActiveRecord
{
    public $dr_amount;
    public $cr_amount;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entryitems';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entry_id', 'dc'], 'required'],
            [['entry_id', 'ledger_id','cheque_no'], 'integer'],
            [['amount','dr_amount','cr_amount'], 'number'],
            [['reconciliation_date'], 'safe'],
            [['dc'], 'string', 'max' => 1],
            [['dr_amount','cr_amount'], 'default', 'value' => 0],
            [['entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entries::className(), 'targetAttribute' => ['entry_id' => 'id']],
            [['ledger_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ledgers::className(), 'targetAttribute' => ['ledger_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entry_id' => 'Entry ID',
            'ledger_id' => 'Ledger ID',
            'amount' => 'Amount',
            'dc' => 'Dc',
            'reconciliation_date' => 'Reconciliation Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntry()
    {
        return $this->hasOne(Entries::className(), ['id' => 'entry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLedger()
    {
        return $this->hasOne(Ledgers::className(), ['id' => 'ledger_id']);
    }

    //Balance Amount for ledger statement (Balance of the amount after each entryitems)
    public function calculateBalanceAmount($balance_amount_dc,$balance_amount)
    {    
         if($balance_amount_dc != $this->dc)
            {
                $balance_amount=$balance_amount - $this->amount;
                if($balance_amount < 0)
                {

                    $balance_amount_dc = $balance_amount_dc == 'D'?'C':'D';
                }
            }   
            else
            {
                 $balance_amount=$balance_amount + $this->amount;
            }      
        $data['balance_amount']=abs($balance_amount);
        $data['balance_amount_dc']=$balance_amount_dc;
        return $data;
    }
}
