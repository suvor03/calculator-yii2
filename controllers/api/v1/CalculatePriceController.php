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

		$totalCost = $prices[$type][$month][$tonnage];

		$priceList = $prices[$type];

		$response = [
			'price' => $totalCost,
			'type' => $type,
			'price_list' => $priceList
		];

		Yii::$app->response->format = Response::FORMAT_JSON;
		return $response;
	}
}