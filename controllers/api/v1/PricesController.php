<?php

namespace app\controllers\api\v1;

use app\models\Months;
use app\models\RawTypes;
use app\models\Tonnages;
use Yii;
use yii\rest\ActiveController;
use app\models\Prices;
use yii\web\Response;

class PricesController extends ActiveController
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
		unset($actions['index'], $actions['create'], $actions['update']);
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

	/**
	 * Summary of actionCreate
	 * @return Prices|array
	 */
	public function actionCreate()
	{
		$data = Yii::$app->getRequest()->getBodyParams();

		$rawTypeName = $data['raw_type_name'];
		$monthName = $data['month_name'];
		$tonnageValue = $data['tonnage_value'];
		$priceValue = $data['price'];

		$transaction = Yii::$app->db->beginTransaction();
		try {
			$rawType = RawTypes::findOne(['name' => $rawTypeName]);
			if (!$rawType) {
				$rawType = new RawTypes(['name' => $rawTypeName]);
				$rawType->save();
			}

			$month = Months::findOne(['name' => $monthName]);
			if (!$month) {
				$month = new Months(['name' => $monthName]);
				$month->save();
			}

			$tonnage = Tonnages::findOne(['value' => $tonnageValue]);
			if (!$tonnage) {
				$tonnage = new Tonnages(['value' => $tonnageValue]);
				$tonnage->save();
			}

			$priceModel = Prices::findOne(['raw_type_name' => $rawTypeName, 'month_name' => $monthName, 'tonnage_value' => $tonnageValue]);
			if (!$priceModel) {
				$priceModel = new Prices();
				$priceModel->raw_type_name = $rawTypeName;
				$priceModel->month_name = $monthName;
				$priceModel->tonnage_value = $tonnageValue;
			}
			$priceModel->price = $priceValue;
			$priceModel->save();

			$transaction->commit();

			return ['success' => true, 'message' => 'Данные успешно сохранены'];
		} catch (\Exception $e) {
			$transaction->rollBack();
			return ['success' => false, 'message' => 'Произошла ошибка при сохранении данных: ' . $e->getMessage()];
		}
	}

	/**
	 * Summary of actionUpdate
	 * @param mixed $id
	 * @return Prices|array
	 */
	public function actionUpdate()
	{
		$raw_type_name = Yii::$app->request->getBodyParam('raw_type_name');
		$month_name = Yii::$app->request->getBodyParam('month_name');
		$tonnage_value = Yii::$app->request->getBodyParam('tonnage_value');

		$price = Prices::find()
			->where([
				'raw_type_name' => $raw_type_name,
				'month_name' => $month_name,
				'tonnage_value' => $tonnage_value
			])
			->one();

		if ($price) {
			$price->load(Yii::$app->request->getBodyParams(), '');
			if ($price->save()) {
				Yii::$app->response->statusCode = 204;
				return $price;
			} else {
				Yii::$app->response->statusCode = 422;
				return $price->getErrors();
			}
		} else {
			Yii::$app->response->statusCode = 404;
			return ['error' => 'Цена для указанных параметров не найдена'];
		}
	}
}