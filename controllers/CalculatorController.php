<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\CalculatorForm;

class CalculatorController extends Controller
{
    public function actionCalculator()
    {
        $model = new CalculatorForm();

        return $this->render('calculator', [
            'model' => $model,
        ]);
    }
	 
    public function actionSubmitForm()
    {
        $model = new CalculatorForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $data = [
                'Месяц' => $model->month,
                'Тип сырья' => $model->rawMaterial,
                'Тоннаж' => $model->tonnage,
            ];

            $file = fopen(Yii::$app->runtimePath . '/queue.job', 'a');
            foreach ($data as $field => $value) {
                fwrite($file, $field . ' => ' . $value . PHP_EOL);
            }
            fclose($file);

            return $this->redirect(['site/calculator']);
        }

        return $this->render('calculator', [
            'model' => $model,
        ]);
    }
}