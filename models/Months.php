<?php

namespace app\models;

use yii\db\ActiveRecord;

class Months extends ActiveRecord
{
 /**
  * Summary of tableName
  * @return string
  */
	public static function tableName()
   {
       return 'months';
   }
	
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