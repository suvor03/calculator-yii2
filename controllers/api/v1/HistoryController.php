<?php

namespace app\controllers\api\v1;

use Yii;
use yii\rest\ActiveController;
use app\models\History;
use yii\web\Response;

class HistoryController extends ActiveController
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

	/**
	 * Summary of actionCreate
	 * @return History|array
	 */
	public function actionCreate()
	{
		$history = new History();
		$user = Yii::$app->user->getIdentity();
    	$username = $user->username;
		
		$history->load(Yii::$app->getRequest()->getBodyParams(), '');
		$history->username = $username;
		
		if ($history->save()) {
			Yii::$app->getResponse()->setStatusCode(201);
			return $history;
		} else {
			Yii::$app->getResponse()->setStatusCode(401);
			return $history->getErrors();
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