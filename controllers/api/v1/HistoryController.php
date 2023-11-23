<?php

namespace app\controllers\api\v1;

use Yii;
use yii\web\Controller;
use app\models\History;
use app\models\Months;
use app\models\RawTypes;
use app\models\Tonnages;
use app\models\Prices;
use app\models\User;

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
    $history = new History();
    $history->username = Yii::$app->getRequest()->getBodyParam('username');
    $history->month_name = Yii::$app->getRequest()->getBodyParam('month_name');
    $history->raw_type_name = Yii::$app->getRequest()->getBodyParam('raw_type_name');
    $history->tonnage_value = Yii::$app->getRequest()->getBodyParam('tonnage_value');
    $history->price = Yii::$app->getRequest()->getBodyParam('price');

    if ($history->validate()) { // Проверка валидности данных
        if ($history->save()) {
            Yii::$app->getResponse()->setStatusCode(201);
            return $history;
        } else {
            Yii::$app->getResponse()->setStatusCode(500); // Указываем статус 500 в случае ошибки сервера
            return $history->getErrors(); // Возвращаем информацию об ошибках
        }
    } else {
        Yii::$app->getResponse()->setStatusCode(422); // Указываем статус 422 в случае неверных данных
        return $history->getErrors(); // Возвращаем информацию об ошибках валидации
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