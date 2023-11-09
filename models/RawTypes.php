<?php

namespace app\models;

use yii\db\ActiveRecord;

class RawTypes extends ActiveRecord
{
	/**
	 * Summary of rules
	 * @return array
	 */
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name'], 'string', 'max' => 50],
			[['name'], 'unique'],
		];
	}
}