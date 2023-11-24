<?php

namespace app\models;

use yii\db\ActiveRecord;


class History extends ActiveRecord
{
	public function rules()
	{
		return [
			[['username', 'month_name', 'price', 'raw_type_name', 'tonnage_value'], 'required'],
		];
	}
}