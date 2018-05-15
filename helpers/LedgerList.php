<?php
namespace app\helpers;

use Yii;
use app\models\Groups;
use app\models\Ledgers;

class LedgerList
{
	private $name='';
	private $code='';
	private $id=null;
	private $children_groups=array();
	private $children_ledgers=array();
	private $counter=0;
	private $defaultText='Please Select';

	private $ledgerList=array();


	function start($id=null)
	{
		if($id != null)
		{
			$group=Groups::findOne($id);
			$this->id=$id;
			$this->name=$group->name;
			$this->code=$group->code;
		}

		$this->addSubLedgers();
		$this->addSubGroups();


	}

	function addSubGroups()
	{
			if($this->id == null)
			{
				$child_groups=Groups::find()->where(['parent_id'=>NULL])->all();
			}
			else
			{
				$child_groups=Groups::find()->where('parent_id=:parent_id',[':parent_id'=>$this->id])->all();
			}

			if($child_groups != null)
			{
				$counter=0;
				foreach ($child_groups as $key => $value) 
				{
					$this->children_groups[$counter]=new LedgerList();

					$this->children_groups[$counter]->id=$value->id;
					$this->children_groups[$counter]->name=$value->name;
					$this->children_groups[$counter]->code=$value->code;

					$this->children_groups[$counter]->start($value->id);
					$counter++;	
				}

			}

	}

	function addSubLedgers()
	{
			$ledgers=Ledgers::find()->where('group_id=:group_id',[':group_id'=>$this->id])->all();
			if($ledgers != null)
			{
				$counter=0;
				foreach ($ledgers as $key => $value) 
				{
						$this->children_ledgers[$counter]['id']=$value->id;
						$this->children_ledgers[$counter]['name']=$value->name;
						$this->children_ledgers[$counter]['code']=$value->code;
						$counter++;
				}

			}
	}

	function buildList($list,$c=0)
	{
			if($list->id != 0)
			{
				$this->ledgerList[-$list->id]=$this->space($c).'---&nbsp;'.Yii::$app->Accounts->ledgerWithReverseCode($list->code,$list->name);
			}
			else
			{
				$this->ledgerList[0]=$this->defaultText;
			}

			if(count($list->children_ledgers) > 0)
			{
				$c+=2;
				foreach ($list->children_ledgers as $key => $value) 
				{
					$this->ledgerList[$value['id']]=$this->space($c).Yii::$app->Accounts->ledgerWithReverseCode($value['code'],$value['name']);
				}
				$c+=2;

			}

			foreach ($list->children_groups as $key => $value) 
			{
				$c++;
				$this->buildList($value, $c);
				$c--;
			}

	}

	function space($count)
	{
		$str = '';
		for ($i = 1; $i <= $count; $i++) {
			$str .= '&nbsp;&nbsp;&nbsp;';
		}
		return $str;
	}

	public function getList()
	{
		return $this->ledgerList;
	}


}





?>