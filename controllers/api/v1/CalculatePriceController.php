<?php

namespace app\controllers\api\v1;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Price;

class CalculatePriceController extends Controller
{
	public function actionIndex()
	{
		$month = Yii::$app->request->get('month');
		$tonnage = Yii::$app->request->get('tonnage');
		$type = Yii::$app->request->get('type');

		$priceList = Price::find()
			->select(['raw_type.name AS rawType', 'month.name AS month', 'tonnage.value AS tonnage', 'price'])
			->innerJoin('month', 'price.month_id = month.id')
			->innerJoin('tonnage', 'price.tonnage_id = tonnage.id')
			->innerJoin('raw_type', 'price.raw_type_id = raw_type.id')
			->where(['raw_type.name' => $type])
			->asArray()
			->all();

		$response = [
			'price' => null,
			'price_list' => [
				$type => []
			]
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