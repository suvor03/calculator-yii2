<?php

namespace app\controllers\api\v1;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class JsonSchemaController extends Controller
{
	/**
	 * Summary of actionIndex
	 * @return bool|string
	 */
	public function actionGetSpec()
	 {
		Yii::$app->response->format = Response::FORMAT_RAW;
		Yii::$app->response->headers->set('Content-Type', 'application/x-yaml');

		ob_start();
		
		include_once Yii::getAlias('@app') . '/swagger/spec.yml';

		return ob_get_clean();
	 }
}