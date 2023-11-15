<?php

namespace app\controllers\api\v1;

use app\models\Tonnages;
use Yii;
use yii\rest\ActiveController;


class TonnagesController extends ActiveController
{
	/**
	 * Summary of modelClass
	 * @var 
	 */
	public $modelClass = 'app\models\Tonnages';

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
		$tonnages = Tonnages::find()->select('value')->asArray()->all();
		return array_column($tonnages, 'value');
	}

	/**
	 * Summary of actionCreate
	 * @return Tonnages|array
	 */
	public function actionCreate()
	{
		$tonnage = new Tonnages();
		$tonnage->load(Yii::$app->getRequest()->getBodyParams(), '');
		if ($tonnage->save()) {
			Yii::$app->getResponse()->setStatusCode(201);
			return $tonnage;
		} else {
			Yii::$app->getResponse()->setStatusCode(401);
			return $tonnage->getErrors();
		}
	}

	/**
	 * Summary of actionDelete
	 * @param mixed $value
	 * @return array
	 */
	public function actionDelete($value)
	{
		$tonnage = Tonnages::findOne(['value' => $value]);
    if ($tonnage) {
        try {
            $tonnage->delete();
            Yii::$app->response->statusCode = 203;
            return ['success' => true, 'message' => 'Тоннаж успешно удален'];
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return ['success' => false, 'message' => 'Ошибка при удалении тоннажа: ' . $e->getMessage()];
        }
    } else {
        Yii::$app->response->statusCode = 404;
        return ['success' => false, 'message' => 'Тоннаж со значением ' . $value . ' не найден'];
    }
	}
}