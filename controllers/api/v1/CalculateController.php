<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\ActiveController;
use app\models\Prices;
use yii\web\Response;

class CalculateController extends ActiveController
{
	/**
	 * Summary of modelClass
	 * @var 
	 */
	public $modelClass = 'app\models\Prices';

	/**
	 * Summary of actions
	 * @return mixed
	 */
	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		return $actions;
	}

	/**
	 * Summary of actionIndex
	 * @return array
	 */
	public function actionIndex()
	{
		$month = Yii::$app->request->get('month');
		$tonnage = Yii::$app->request->get('tonnage');
		$type = Yii::$app->request->get('type');

		$price = Prices::find()
			->select('price')
			->where([
				'month_name' => $month,
				'tonnage_value' => $tonnage,
				'raw_type_name' => $type
			])
			->scalar();

		$priceList = Prices::find()
			->select(['price', 'months.name as month', 'tonnages.value as tonnage', 'raw_types.name as type'])
			->innerJoinWith('months')
			->innerJoinWith('rawTypes')
			->innerJoinWith('tonnages')
			->where(['raw_types.name' => $type])
			->orderBy(['months.id' => SORT_ASC])
			->asArray()
			->all();

		$response = [
			'price' => $price,
			'price_list' => []
		];

		foreach ($priceList as $item) {
			$itemMonth = $item['month'];
			$itemTonnage = $item['tonnage'];
			$price = $item['price'];

			$response['price_list'][$type][$itemMonth][$itemTonnage] = $price;

			if ($itemMonth === $month && $itemTonnage === $tonnage) {
				$response['price'] = $price;
			}
		}

		foreach ($response['price_list'][$type] as &$monthData) {
			ksort($monthData);
	  }

		Yii::$app->response->format = Response::FORMAT_JSON;
		return $response;
	}
}