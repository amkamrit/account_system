<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entries".
 *
 * @property string $id
 * @property string $tag_id
 * @property string $entrytype_id
 * @property string $number
 * @property string $date
 * @property string $dr_total
 * @property string $cr_total
 * @property string $narration
 *
 * @property Entrytypes $entrytype
 * @property Tags $tag
 * @property Entryitems[] $entryitems
 */
class Entries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_id', 'entrytype_id', 'number','created_by'], 'integer'],
            [['entrytype_id', 'date'], 'required'],
            [['date','created_at'], 'safe'],
            [['dr_total', 'cr_total'], 'number'],
            [['narration'], 'string', 'max' => 500],
            //['created_by', 'default', 'value' => Yii::$app->user->identity->id],
            [['entrytype_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entrytypes::className(), 'targetAttribute' => ['entrytype_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tags::className(), 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_id' => 'Tag',
            'entrytype_id' => 'Entry Type',
            'number' => 'Number',
            'date' => 'Date (YYYY-MM-DD)',
            'dr_total' => 'Debit Amount',
            'cr_total' => 'Credit Amount',
            'narration' => 'Narration',
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) 
        {
                if($insert)
                {
                    if (Yii::$app->user->isGuest) 
                    {
                        $this->created_by=100;
                    }
                    else
                    {
                        $this->created_by=Yii::$app->user->identity->id;
                    }
                    if($this->number == null)
                    {
                        //Setting Entry Number
                        $numberM=Entries::find()->orderBy(['number'=>SORT_DESC])->one();
                        if($numberM == null)
                        $this->number=1;
                    else
                        $this->number=$numberM->number +1;
                    }
                }
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
    public function getEntrytype()
    {
        return $this->hasOne(Entrytypes::className(), ['id' => 'entrytype_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tags::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntryitems()
    {
        return $this->hasMany(Entryitems::className(), ['entry_id' => 'id'])->orderBy(['dc' => SORT_DESC]);
    }



     // Returns the Ledger entry for the view in table for Ledger Statement.
    public function getLedgerFormatLedgerStatement($cheque=null,$ledger=null)
    {
        $allitems=$this->entryitems;
        $formatTextDr="";
        $formatTextCr="";
        $formatChequeCr="";
        $formatChequeDr="";
       
        foreach ($allitems as $key => $value) 
        {
            if($value->dc == "D")
            {
                
                    $formatTextDr.=  Yii::$app->Accounts->ledgerWithCode($value->ledger->code,$value->ledger->name).'<br>';
                    $formatChequeDr.=  $value->cheque_no.'<br>';
                    
            }
            else
            {
                    $formatTextCr .= "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspTo,".   Yii::$app->Accounts->ledgerWithCode($value->ledger->code,$value->ledger->name).'<br>';   
                     $formatChequeCr.=  $value->cheque_no.'<br>';
            }
        }

        if($cheque)
            $finalFormat=$formatChequeDr.$formatChequeCr;
        else
            $finalFormat=$formatTextDr.$formatTextCr;
        return $finalFormat;

    }

    // Returns the Ledger entry for the view in table.
    public function getLedgerFormat()
    {
        $allitems=$this->entryitems;
        $formatTextDr="";
        $formatTextCr="";
        $counter=0;
        $counterC=0;
        foreach ($allitems as $key => $value) 
        {
            if($value->dc == "D")
            {
                if($counter == 1)
                {
                    $formatTextDr.="[+]";
                    $counter++;
                }
                elseif($counter == 0)
                {
                    $formatTextDr.= "<b>Dr</b> ".$value->ledger->name."";
                    $counter++;
                }
            }
            else
            {
                if($counterC == 1)
                {
                    $formatTextCr.="[+]";
                    $counterC++;
                }
                elseif($counterC == 0)
                {
                    $formatTextCr .= "<b>Cr</b> ".$value->ledger->name."";
                    $counterC++;
                }
            }
        }
        $finalFormat=$formatTextDr.'/'.$formatTextCr;
        return $finalFormat;

    }



    // Returns the Ledger entry for the view in table for CSV.
    public function getLedgerFormatCsv()
    {
        $allitems=$this->entryitems;
        $formatTextDr="";
        $formatTextCr="";
        $counter=0;
        $counterC=0;
        foreach ($allitems as $key => $value) 
        {
            if($value->dc == "D")
            {
                if($counter == 1)
                {
                    $formatTextDr .= "Dr ".$value->ledger->name."[+]";                    
                    //$counter++;
                }
                elseif($counter == 0)
                {
                    $formatTextDr.= "Dr ".$value->ledger->name."";
                    $counter++;
                }
            }
            else
            {
                if($counterC == 1)
                {
                    $formatTextCr .= "Cr ".$value->ledger->name."[+]";
                    //$counterC++;
                }
                elseif($counterC == 0)
                {
                    $formatTextCr .= "Cr ".$value->ledger->name."";
                    $counterC++;
                }
            }
        }
        $finalFormat=$formatTextDr.'/'.$formatTextCr;
        return $finalFormat;

    }
}
