<?php

namespace app\controllers\api\v1;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class CalculatePriceController extends Controller
{
	public function actionIndex()
	{
		$month = Yii::$app->request->get('month');
		$tonnage = Yii::$app->request->get('tonnage');
		$type = Yii::$app->request->get('type');

		$prices = require(Yii::getAlias('@app/config/prices.php'));

		$priceTable = $prices[$type][$month];

		$totalCost = null;
		foreach ($priceTable as $price) {
			if (isset($price[$tonnage])) {
				$totalCost = $price[$tonnage];
				break;
			}
		}

		$priceList = [];

		foreach ($prices as $rawType => $months) {
			if ($rawType === $type) {
				$priceList[$type] = [];

				foreach ($months as $month => $values) {
					$priceList[$type][$month] = [];

					foreach ($values as $value) {
						$tonnage = key($value);
						$price = $value[$tonnage];

						$priceList[$type][$month][$tonnage] = $price;
					}
				}
			}
		}

		$response = [
			'price' => $totalCost,
			'price_list' => $priceList
		];

		Yii::$app->response->format = Response::FORMAT_JSON;
		return $response;
	}
}