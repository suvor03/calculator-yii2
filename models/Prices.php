<?php

namespace app\models;

use yii\db\ActiveRecord;

class Prices extends ActiveRecord
{
	/**
	 * Summary of getMonths
	 * @return \yii\db\ActiveQuery
	 */
	public function getMonths()
	{
		return $this->hasOne(Months::class, ['id' => 'month_id']);
	}
	/**
	 * Summary of getRawTypes
	 * @return \yii\db\ActiveQuery
	 */
	public function getRawTypes()
	{
		return $this->hasOne(RawTypes::class, ['id' => 'raw_type_id']);
	}
	/**
	 * Summary of getTonnages
	 * @return \yii\db\ActiveQuery
	 */
	public function getTonnages()
	{
		return $this->hasOne(Tonnages::class, ['id' => 'tonnage_id']);
	}
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
			[['month_id', 'raw_type_id', 'tonnage_id', 'price'], 'required'],
		];
	}
}