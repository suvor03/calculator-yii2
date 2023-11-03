<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
	public $month;
	public $rawType;
	public $tonnage;

	public function rules()
	{
		return [
			[['month', 'rawType', 'tonnage'], 'required'],
		];
	}
}