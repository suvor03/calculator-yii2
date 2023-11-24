<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\History;
use Yii;
use yii\web\ForbiddenHttpException;
use app\models\HistorySearch;


class CalculationController extends Controller
{

	public function actionHistory()
	{
		$searchModel = new HistorySearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('history', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($id)
{
    $model = History::findOne($id);

	 return $this->render('view', [
		'model' => $model,
	]);
}


	public function actionDelete($id)
	{
		if (Yii::$app->user->can('administrator') || Yii::$app->user->can('super_admin')) {
			$model = History::findOne($id);

			if ($model !== null) {
				$model->delete();
			}

			return $this->redirect(['history']);
		} else {
			throw new ForbiddenHttpException('You are not allowed to perform this action.');
		}
	}
}