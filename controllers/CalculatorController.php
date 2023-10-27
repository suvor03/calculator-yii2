<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\CalculatorForm;

class CalculatorController extends Controller
{
	public function actionCalculator()
	{
		$model = new CalculatorForm();

		return $this->render('calculator', [
			'model' => $model,
		]);
	}

	public function actionSubmitForm()
	{
		$model = new CalculatorForm();

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			Yii::$app->session->setFlash('success','Валидация формы пройдена успешно!');
			$data = [
				'Месяц' => $model->month,
				'Тип сырья' => $model->rawMaterial,
				'Тоннаж' => $model->tonnage,
			];

			$file = fopen(Yii::$app->runtimePath . '/queue.job', 'a');
			foreach ($data as $field => $value) {
				fwrite($file, $field . ' => ' . $value . PHP_EOL);
			}
			fclose($file);

			
			$rawMaterial = $model->rawMaterial;
			$month = $model->month;
			$tonnage = $model->tonnage;

			$prices = require(Yii::getAlias('@app/config/prices.php'));

			$priceTable = $prices[$rawMaterial][$month];

			$totalCost = null;
			foreach ($priceTable as $price) {
				if ($price['тоннаж'] == $tonnage) {
					$totalCost = $price['price'];
					break;
				}
			}

			return $this->render('../site/result', [
				'rawMaterial' => $rawMaterial,
				'month' => $month,
				'tonnage' => $tonnage,
				'totalCost' => $totalCost,
			]);
		} else {
			Yii::$app->session->setFlash('error', 'Ошибка валидации!');
		}
	}
}