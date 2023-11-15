<?php

namespace app\models;

use yii\db\ActiveRecord;

class Prices extends ActiveRecord
{
 /**
  * Summary of primaryKey
  * @return array
  */
	public static function primaryKey()
    {
        return ['id'];
    }
	/**
	 * Summary of getMonths
	 * @return \yii\db\ActiveQuery
	 */
	public function getMonths()
	{
		return $this->hasOne(Months::class, ['name' => 'month_name']);
	}
	/**
	 * Summary of getRawTypes
	 * @return \yii\db\ActiveQuery
	 */
	public function getRawTypes()
	{
		return $this->hasOne(RawTypes::class, ['name' => 'raw_type_name']);
	}
	/**
	 * Summary of getTonnages
	 * @return \yii\db\ActiveQuery
	 */
	public function getTonnages()
	{
		return $this->hasOne(Tonnages::class, ['value' => 'tonnage_value']);
	}
	/**
	 * Summary of rules
	 * @return array
	 */
	public function rules()
	{
		return [
			[['price'], 'required'],
			[['price'], 'number'],
			[['price'], 'compare', 'compareValue' => 0, 'operator' => '>', 'message' => 'Значение должно быть больше нуля'],
			[['month_name', 'raw_type_name', 'tonnage_value', 'price'], 'required'],
		];
	}
}