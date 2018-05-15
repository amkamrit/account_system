<?php
namespace app\helpers;

use Yii;
use yii\base\Component;
use app\models\Entryitems;
use yii\web\NotFoundHttpException;
use app\models\Ledgers;
use app\models\Accounts;


class AccountsHelper extends Component 
{
	
	//Calculate the Closing Balance of a Ledger.
	public function closingBalance($ledger_id,$start_date,$end_date)
	{
		$data=array();
		$op=Ledgers::findOne($ledger_id)->op_balance;
		if($op != 0)
		$opdc=Ledgers::findOne($ledger_id)->op_balance_dc;
		else
		$opdc='';
		$balance=0;
		$ledgerEntryItems=$this->entryItems($ledger_id,$start_date,$end_date);
		$dr_total=0;
		$cr_total=0;
		$cl_total_dc='';
		$cl_total=0;
		$op_total=$op;
		$op_total_dc=$opdc;
		if($ledgerEntryItems == null)
		{

			//Adding Opening Balances
			$only_dr_total=$dr_total;
			$only_cr_total=$cr_total;

			if($opdc == "D")
				$dr_total+=$op;
			elseif($opdc == "C")
				$cr_total+=$op;

			if($dr_total > $cr_total)
			{
				$cl_total_dc="D";
				$cl_total=$dr_total - $cr_total;
			}
			else if($dr_total < $cr_total)
			{
				$cl_total_dc="C";
				$cl_total=$cr_total - $dr_total;	
			}

			$data=
			[
				'dr_total'=>$only_dr_total,
				'cr_total'=>$only_cr_total,
				'cl_total'=>$cl_total,
				'cl_total_dc'=>$cl_total_dc,
				'op_total'=>$op_total,
				'op_total_dc'=>$op_total_dc

			];

			return $data;
		}
		else
		{
			foreach ($ledgerEntryItems as $key => $value) 
			{
					if($value->dc == "D")
					{
						$dr_total+=$value->amount;
					}
					else
					{
						$cr_total+=$value->amount;
					}
			}

		}

		$only_dr_total=$dr_total;
		$only_cr_total=$cr_total;

		if($opdc == "D")
		$dr_total+=$op;
		elseif($opdc == "C")
		$cr_total+=$op;

		if($dr_total > $cr_total)
		{
			$cl_total_dc="D";
			$cl_total=$dr_total - $cr_total;
		}
		else if($dr_total < $cr_total)
		{
			$cl_total_dc="C";
			$cl_total=$cr_total - $dr_total;	
		}
	

		$data=
		[
			'dr_total'=>$only_dr_total,
			'cr_total'=>$only_cr_total,
			'cl_total'=>$cl_total,
			'cl_total_dc'=>$cl_total_dc,
			'op_total'=>$op_total,
			'op_total_dc'=>$op_total_dc
		];
		return $data;
	}

	/** 
	Calculate the Current Closing Balance of a parent
	Also used for difference between two amount
	*/
	public function currentClosingBalance($cl_total,$cl_total_dc,$child_total,$child_total_dc)
	{
			$cl_total=round($cl_total,2);
			$child_total=round($child_total,2);
			if($cl_total_dc == '' && $child_total_dc =='')
			{

			}
			else if($cl_total_dc == '' && $child_total_dc !='')
			{
				$cl_total_dc=$child_total_dc;
				$cl_total=$child_total;

			}
			else if($cl_total_dc != '' && $child_total_dc =='')
			{
				
			}
			else if($child_total_dc != $cl_total_dc)
            {
                $cl_total=$cl_total - $child_total;
                if($cl_total < 0)
                {

                    $cl_total_dc = $cl_total_dc == 'D'?'C':'D';
                }
            }   
            else
            {
                 $cl_total=$cl_total + $child_total;
            }   


        $data['amount']=abs($cl_total);
        $data['amount_dc']=$cl_total_dc;
		return $data;

	}

	/**
		If Start data and end date is specified then only entries between dates will be returned.
		Used for getting all entry items of individual ledger according to date. Return all entryitems if date is not specified
	*/
	public function entryItems($ledger_id,$start_date=null,$end_date=null)
	{
		if($start_date != null && $end_date != null)
		{
			return EntryItems::find()->where('ledger_id =:id AND entries.date >=:sdate AND entries.date <=:edate',[':id'=>$ledger_id,':sdate'=>$start_date,':edate'=>$end_date])->joinWith('entry')->orderBy(['entries.date'=>SORT_ASC])->all();
		}
		else
		{
			return Entryitems::find()->where('ledger_id=:id',[':id'=>$ledger_id])->joinWith('entry')->orderBy(['entries.date'=>SORT_ASC])->all();
		}
	}

	public function currentDcBalance($total,$child_total)
	{
			return $total+$child_total;

	}

	
	/** 
	Convert D or C to Dr or Cr with string formatted
	*/
	public function convertDcPrefix($dc,$amount)
	{

		$dc=strtolower($dc);
		$dc=preg_replace('/\s+/', '', $dc);
		if(($amount != 0) && ($dc == 'd' || $dc == 'dr'))
		{
			return 'Dr. '.round($amount,2);
		}
		else if(($amount != 0) && ($dc =='c' || $dc == 'cr'))
		{
			return 'Cr. '.round($amount,2);
		}
		else
		{
			return 0;
		}
	}


	//Return all profit and loss informations
	public function profitAndLossCalculation($start_date=null,$end_date=null)
	{

        /* Gross Income  */
        $gross_incomes = new Accounts();
        $gross_incomes->only_opening = false;
        $gross_incomes->start_date = $start_date;
        $gross_incomes->end_date = $end_date;
        $gross_incomes->affects_gross = 1;
        $gross_incomes->start(3);

        $pal['gross_incomes']=$gross_incomes;
        $pal['gross_income_total']=0;
        $pal['gross_income_total']=$gross_incomes->cl_total;
        $pal['gross_income_total_dc']=$gross_incomes->cl_total_dc;


        /* Gross Expense  */
        $gross_expenses = new Accounts();
        $gross_expenses->only_opening = false;
        $gross_expenses->start_date = $start_date;
        $gross_expenses->end_date = $end_date;
        $gross_expenses->affects_gross = 1;
        $gross_expenses->start(4);

        $pal['gross_expenses']=$gross_expenses;
        $pal['gross_expense_total']=0;
        $pal['gross_expense_total']=$gross_expenses->cl_total;
        $pal['gross_expense_total_dc']=$gross_expenses->cl_total_dc;

        $pal['grossData']=Yii::$app->Accounts->currentClosingBalance($pal['gross_income_total'],$pal['gross_income_total_dc'],$pal['gross_expense_total'],$pal['gross_expense_total_dc']);

       

         /* Net Income  */
        $net_incomes = new Accounts();
        $net_incomes->only_opening = false;
        $net_incomes->start_date = $start_date;
        $net_incomes->end_date = $end_date;
        $net_incomes->affects_gross = 0;
        $net_incomes->start(3);

        $pal['net_incomes']=$net_incomes;
        $pal['net_income_total']=0;
        $pal['net_income_total']=$net_incomes->cl_total;
        $pal['net_income_total_dc']=$net_incomes->cl_total_dc;

         /* Net Expense  */
        $net_expenses = new Accounts();
        $net_expenses->only_opening = false;
        $net_expenses->start_date = $start_date;
        $net_expenses->end_date = $end_date;
        $net_expenses->affects_gross = 0;
        $net_expenses->start(4);

        $pal['net_expenses']=$net_expenses;
        $pal['net_expense_total']=0;
        $pal['net_expense_total']=$net_expenses->cl_total;
        $pal['net_expense_total_dc']=$net_expenses->cl_total_dc;

        
        if($pal['net_expense_total'] == 0)  $pal['net_expense_total_dc']='D';
        if($pal['net_income_total'] == 0)  $pal['net_income_total_dc']='C';        

        if($pal['grossData']['amount_dc'] == 'D')
        {

        	 $temp_expense=Yii::$app->Accounts->currentClosingBalance($pal['net_expense_total'],$pal['net_expense_total_dc'],$pal['grossData']['amount'],$pal['grossData']['amount_dc']);

             $pal['netData']=Yii::$app->Accounts->currentClosingBalance($pal['net_income_total'],$pal['net_income_total_dc'],$temp_expense['amount'],$temp_expense['amount_dc']);
        }
        else
        {
        	$temp_income=Yii::$app->Accounts->currentClosingBalance($pal['net_income_total'],$pal['net_income_total_dc'],$pal['grossData']['amount'],$pal['grossData']['amount_dc']);

             $pal['netData']=Yii::$app->Accounts->currentClosingBalance($temp_income['amount'],$temp_income['amount_dc'],$pal['net_expense_total'],$pal['net_expense_total_dc']); 
        }
    
        $pal['netData']['grossPl']=$pal['grossData']['amount'];
        $pal['netData']['grossPl_dc']=$pal['grossData']['amount_dc'];
        return $pal;
	}


	/**
		Return Ledger/Group Account with code in formatted String
	*/

	public function ledgerWithCode($code,$ledger)
	{
		if($code == null)
		{
			return $ledger;
		}
		else
		{
			return '['.$code.'] '.$ledger;
		}

	}


	/**
		Return Ledger/Group Account with code in formatted String with code at last
	*/

	public function ledgerWithReverseCode($code,$ledger)
	{
		if($code == null)
		{
			return $ledger;
		}
		else
		{
			return $ledger.'['.$code.']';
		}

	}


	/**
		Return which parent id does ledger belong to
	*/
	public function superParentId($ledger)
	{
		$parent_group=$ledger->group;
		$parent_id=null;
		while($parent_id != 1 && $parent_id != 2 && $parent_id != 3 && $parent_id != 4)
		{

			$parent_group=$parent_group->parent;
			$parent_id=$parent_group->id;

		}
		return $parent_id;

	}


}
?>