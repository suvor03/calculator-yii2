<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\ActiveController;
use app\models\Months;

class MonthsController extends ActiveController
{
	/**
	 * Summary of modelClass
	 * @var 
	 */
	public $modelClass = 'app\models\Months';

	/**
	 * Summary of actions
	 * @return mixed
	 */
	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index'], $actions['create'], $actions['delete']);
		return $actions;
	}

	/**
	 * Summary of actionIndex
	 * @return array
	 */
	public function actionIndex()
	{
		$months = Months::find()->select('name')->orderBy('id')->asArray()->all();
		return array_column($months, 'name');
	}

	/**
	 * Summary of actionCreate
	 * @return Months|array
	 */
	public function actionCreate()
	{
		$month = new Months();
		$month->load(Yii::$app->getRequest()->getBodyParams(), '');
		if ($month->save()) {
			Yii::$app->getResponse()->setStatusCode(201);
			return $month;
		} else {
			Yii::$app->getResponse()->setStatusCode(401);
			return $month->getErrors();
		}
	}

	/**
	 * Summary of actionDelete
	 * @param mixed $name
	 * @return array
	 */
	public function actionDelete($name)
	{
		$decodedName = urldecode($name);
		$month = Months::findOne(['name' => $decodedName]);
		if ($month) {
			try {
				$month->delete();
				Yii::$app->response->statusCode = 203;
				return ['success' => true, 'message' => 'Месяц успешно удален'];
			} catch (\Exception $e) {
				Yii::$app->response->statusCode = 500;
				return ['success' => false, 'message' => 'Ошибка при удалении месяца: ' . $e->getMessage()];
			}
		} else {
			Yii::$app->response->statusCode = 404;
			return ['success' => false, 'message' => 'Месяц с именем ' . $name . ' не найден'];
		}
	}
}