<?php

namespace app\models;

use yii\db\ActiveRecord;

class Price extends ActiveRecord
{
	/**
	 * Summary of rules
	 * @return array
	 */
	public function rules()
	{
		return [
			[['value'], 'required'],
			[['value'], 'number'],
			[['value'], 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => 'Значение должно быть больше нуля'],
		];
	}
}