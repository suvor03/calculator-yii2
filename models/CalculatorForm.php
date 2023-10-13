<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
	public $month;
	public $rawMaterial;
	public $tonnage;

	public function rules()
	{
		return [
			[['month', 'rawMaterial', 'tonnage'], 'required'],
		];
	}
}