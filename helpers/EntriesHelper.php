<?php
namespace app\helpers;

use Yii;
use yii\base\Component;
use app\models\Settings;

use yii\web\NotFoundHttpException;



class EntriesHelper extends Component 
{
	
	public static function calculateDrTotal()
	{
			$dr_amount=0;
           
            foreach (Yii::$app->request->post('Entryitems') as $key => $value) 
            {
                if(isset($value['dr_amount']))
                $dr_amount+=$value['dr_amount'];
            }
            return $dr_amount;
	}

	public static function calculateCrTotal()
	{
            $cr_amount=0;
            foreach (Yii::$app->request->post('Entryitems') as $key => $value) 
            {
                if(isset($value['cr_amount']))
                $cr_amount+=$value['cr_amount'];
            }
            return $cr_amount;
	}

    //Check if date lies between financial start and end year date...
    public static function checkFinancialYearDate($date)
    {
        $setting=Settings::findOne(1);
        if($date >= $setting->fy_start && $date <= $setting->fy_end)
        {
            return false;
        }
        else
        {
            return true;
        }

           
    }


}

?>