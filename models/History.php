<?php

namespace app\models;

use yii\db\ActiveRecord;


class History extends ActiveRecord
{

	public static function tableName()
	{
		return 'history';
	}

	public function rules()
	{
		return [
			[['month_name', 'raw_type_name', 'tonnage_value', 'price'], 'required'],
		];
	}
}