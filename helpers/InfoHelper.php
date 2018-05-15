<?php
namespace app\helpers;

use Yii;
use yii\base\Component;
use app\models\Setting;
use yii\web\NotFoundHttpException;
use app\models\Settings;



class InfoHelper extends Component 
{
	private static $entrytype_id=4;

	public function getEntryTypeId()
	{
		return InfoHelper::$entrytype_id;
	}

	public function isSettingSet()
	{
		$setting=Settings::findOne(1);
        if($setting == null) return false;
        else return true;

	}


	public function getClientName()
	{
		return Settings::findOne(1)->name;
	}

	public function getClientAddress()
	{
		return Settings::findOne(1)->address;
	}

	public function getClientCode()
	{
		return Settings::findOne(1)->code;
	}

	public function getClientContactNo()
	{
		return Settings::findOne(1)->contact_no;
	}

	public function getClientFyStart()
	{
		return Settings::findOne(1)->fy_start;
	}

	public function getClientFyEnd()
	{
		return Settings::findOne(1)->fy_end;
	}

	public function getDeveloperCompany()
	{
		return "Encraft Technologies";
	}

	public function getSoftwareName()
	{
		return "Account";
	}


}

?>