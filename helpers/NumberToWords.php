<?php
namespace app\helpers;

use Yii;
use yii\base\Component;
use app\models\Setting;
use yii\web\NotFoundHttpException;
use app\models\Settings;



class NumberToWords extends Component 
{

public function numberToWords($number)
	{
		if (($number < 0) || ($number > 999999999)) {
			throw new Exception("Number is out of range");
		}

		$Gn = floor($number / 1000000);  /* Millions (giga) */
		$number -= $Gn * 1000000;
		$kn = floor($number / 1000);  /* Thousands (kilo) */
		$number -= $kn * 1000;
		$Hn = floor($number / 100);   /* Hundreds (hecto) */
		$number -= $Hn * 100;
		$Dn = floor($number / 10); /* Tens (deca) */
		$n = $number % 10;   /* Ones */

		$res_ult = "";

		if ($Gn) {
			$res_ult .= $this->numberToWords($Gn) . " Million";
		}


		if ($kn) {
			$res_ult .= (empty($res_ult) ? "" : " ") .
				$this->numberToWords($kn) . " Thousand";
		}

		if ($Hn) {
			$res_ult .= (empty($res_ult) ? "" : " ") .
				$this->numberToWords($Hn) . " Hundred";
		}

		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
			"Nineteen");
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
			"Seventy", "Eigthy", "Ninety");

		if ($Dn || $n) {
			if (!empty($res_ult)) {
				$res_ult .= " and ";
			}


			if ($Dn < 2) {
				$res_ult .= $ones[$Dn * 10 + $n];
			} else {
				$res_ult .= $tens[$Dn];


				if ($n) {
					$res_ult .= "-" . $ones[$n];
				}
			}
		}

		if (empty($res_ult)) {
			$res_ult = "zero";
		}
		return $res_ult;
	}

 
}