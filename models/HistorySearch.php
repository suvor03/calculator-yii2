<?php

namespace app\models;

use yii\data\ActiveDataProvider;
use app\models\History;

class HistorySearch extends History
{
	public static function tableName()
	{
		return 'history';
	}

	public function rules()
	{
		return [
			[['username', 'raw_type_name', 'tonnage_value', 'month_name', 'price'], 'safe'],
		];
	}

	public function search($params)
	{
		$query = History::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$query->andFilterWhere(['=', 'raw_type_name', $this->raw_type_name])
			->andFilterWhere(['=', 'username', $this->username])
			->andFilterWhere(['=', 'tonnage_value', $this->tonnage_value])
			->andFilterWhere(['=', 'month_name', $this->month_name])
			->andFilterWhere(['=', 'price', $this->price]);

		return $dataProvider;
	}
}