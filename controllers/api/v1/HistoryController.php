<?php

namespace app\controllers\api\v1;

use Yii;
use yii\web\Controller;
use app\models\History;
use yii\web\Response;

class HistoryController extends Controller
{
	/**
	 * Summary of modelClass
	 * @var 
	 */
	public $modelClass = 'app\models\History';

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
		$histories = History::find()->all();
		return $histories;
	}

	public function actionCreate()
	{
		Yii::$app->response->format = Response::FORMAT_JSON;
		$model = new History();

		$postData = Yii::$app->request->getBodyParams();

		if (isset($postData['month_name'], $postData['raw_type_name'], $postData['tonnage_value'], $postData['price'])) {
			$model->attributes = $postData;

			if ($model->save()) {
				return ['success' => true, 'id' => $model->id];
			} else {
				return ['success' => false, 'errors' => $model->errors];
			}
		} else {
			return ['success' => false, 'error' => 'Missing required fields'];
		}
	}

	/**
	 * Summary of actionDelete
	 * @param mixed $id
	 * @return array
	 */
	public function actionDelete($id)
	{
		$history = History::findOne(['id' => $id]);
		if ($history) {
			try {
				$history->delete();
				Yii::$app->response->statusCode = 203;
				return ['success' => true, 'message' => 'История расчета успешно удалена'];
			} catch (\Exception $e) {
				Yii::$app->response->statusCode = 500;
				return ['success' => false, 'message' => 'Ошибка при удалении истории расчета: ' . $e->getMessage()];
			}
		} else {
			Yii::$app->response->statusCode = 404;
			return ['success' => false, 'message' => 'История расчета с id = ' . $id . ' не найдена'];
		}
	}

}