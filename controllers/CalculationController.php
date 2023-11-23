<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\History;


class CalculationController extends Controller
{
	
	public function actionHistory()
	{
		return $this->render('history');
	}

	public function actionSaveCalculation()
{
	$data = Yii::$app->getRequest()->getBodyParams();
	
	$rawTypeName = $data['raw_type_name'];
		$monthName = $data['month_name'];
		$tonnageValue = $data['tonnage_value'];
		$priceValue = $data['price'];

    $model = new History();
    $model->username= Yii::$app->user->getName();
    $model->raw_type_name = $rawTypeName;
    $model->tonnage_value = $tonnageValue;
    $model->month_name = $monthName;
	 $model->price = $priceValue;
    $model->created_at = date('Y-m-d H:i:s');
    // Сохранение модели
    if ($model->save()) {
		return 'Успешно';
    } else {
        return 'Ошибка сохранения данных';
    }
}
}