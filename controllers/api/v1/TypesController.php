<?php

namespace app\controllers\api\v1;

use Yii;
use app\models\RawTypes;
use yii\rest\ActiveController;

class TypesController extends ActiveController
{
	/**
	 * Summary of modelClass
	 * @var 
	 */
	public $modelClass = 'app\models\RawTypes';

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
		$types = RawTypes::find()->select('name')->asArray()->all();
		return array_column($types, 'name');
	}

	/**
	 * Summary of actionCreate
	 * @return RawTypes|array
	 */
	public function actionCreate()
	{
		$type = new RawTypes();
		$type->load(Yii::$app->getRequest()->getBodyParams(), '');
		if ($type->save()) {
			Yii::$app->getResponse()->setStatusCode(201);
			return $type;
		} else {
			Yii::$app->getResponse()->setStatusCode(401);
			return $type->getErrors();
		}
	}


	/**
	 * Summary of actionDelete
	 * @param mixed $name
	 * @return array
	 */
	public function actionDelete($name)
	{
		$type = RawTypes::findOne(['name' => $name]);
    if ($type) {
        try {
            $type->delete();
            Yii::$app->response->statusCode = 203;
            return ['success' => true, 'message' => 'Тип сырья успешно удален'];
        } catch (\Exception $e) {
            Yii::$app->response->statusCode = 500;
            return ['success' => false, 'message' => 'Ошибка при удалении типа сырья: ' . $e->getMessage()];
        }
    } else {
        Yii::$app->response->statusCode = 404;
        return ['success' => false, 'message' => 'Тип сырья с именем ' . $name . ' не найден'];
    }
	}
}