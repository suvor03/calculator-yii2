<?php

namespace app\models;

use yii\db\ActiveRecord;

class RawType extends ActiveRecord
{
	public function rules()
	{
		return [
			[['name'], 'required'],
			[['name'], 'string', 'max' => 50],
			[['name'], 'unique'],
		];
	}
}