<?php

namespace app\models;

use yii\base\Model;

class CalculatorForm extends Model
{
	public string $month = '';
	public string $rawType = '';
	public int $tonnage = 0;

	/**
	 * Summary of rules
	 * @return array
	 */
	public function rules()
	{
		return [
			[['month', 'rawType', 'tonnage'], 'required'],
		];
	}
}