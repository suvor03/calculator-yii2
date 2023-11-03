<?php

namespace app\models;

use yii\db\ActiveRecord;

class Month extends ActiveRecord
{
	/**
	 * Summary of rules
	 * @return array
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name'], 'string', 'max' => 10],
			[['name'], 'unique'],
		];
	}
}