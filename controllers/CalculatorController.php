<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\CalculatorForm;
use app\models\Price;

class CalculatorController extends Controller
{
	public function actionSubmitForm()
	{
		$model = new CalculatorForm();

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			Yii::$app->session->setFlash('success', 'Валидация формы пройдена успешно!');
			$data = [
				'Месяц' => $model->month,
				'Тип сырья' => $model->rawType,
				'Тоннаж' => $model->tonnage,
			];

			$file = fopen(Yii::$app->runtimePath . '/queue.job', 'a');
			foreach ($data as $field => $value) {
				fwrite($file, $field . ' => ' . $value . PHP_EOL);
			}
			fclose($file);


			$rawType = $model->rawType;
			$month = $model->month;
			$tonnage = $model->tonnage;

			$totalCost = Price::find()
				->select('price')
				->innerJoin('month', 'price.month_id = month.id')
				->innerJoin('tonnage', 'price.tonnage_id = tonnage.id')
				->innerJoin('raw_type', 'price.raw_type_id = raw_type.id')
				->where([
					'month.name' => $month,
					'tonnage.value' => $tonnage,
					'raw_type.name' => $rawType,
				])
				->one();

			if ($totalCost !== null) {
				$totalCost = $totalCost->price;
			} else {
				Yii::$app->session->setFlash('error', 'Стоимость не найдена!');
			}

			return $this->render('../site/result', [
				'rawType' => $rawType,
				'month' => $month,
				'tonnage' => $tonnage,
				'totalCost' => $totalCost,
			]);
		} else {
			Yii::$app->session->setFlash('error', 'Ошибка валидации!');
		}
	}
}