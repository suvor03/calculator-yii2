<?php

namespace app\controllers\api\v1;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Prices;

class CalculatePriceController extends Controller
{
	/**
	 * Summary of actionIndex
	 * @return array
	 */
	public function actionIndex()
	{
		$month = Yii::$app->request->get('month');
		$tonnage = Yii::$app->request->get('tonnage');
		$type = Yii::$app->request->get('type');

		$priceList = Prices::find()
			->select(['price', 'months.name as month', 'tonnages.value as tonnage', 'raw_types.name as type'])
			->innerJoinWith('months')
			->innerJoinWith('rawTypes')
			->innerJoinWith('tonnages')
			->asArray()
			->all();

		$response = [
			'price' => null,
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

		Yii::$app->response->format = Response::FORMAT_JSON;
		return $response;
	}
}