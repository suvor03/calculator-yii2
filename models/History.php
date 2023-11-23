<?php

namespace app\models;


class History extends \yii\db\ActiveRecord
{
	public $username;
    public $month_name;
    public $raw_type_name;
    public $tonnage_value;
    public $price;
	 
	/**
  * Summary of primaryKey
  * @return array
  */
  public static function primaryKey()
  {
		return ['id'];
  }

  public function rules()
    {
        return [
			[['username', 'month_name', 'raw_type_name', 'tonnage_value', 'price'], 'required'],
        ];
    }
}