<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Калькулятор стоимости доставки сырья';
$this->params['breadcrumbs'][] = $this->title;
?>

<head>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
	<div class="site-calculator">
		<h1>
			<?= Html::encode($this->title) ?>
		</h1> <br>

		<?php $form = ActiveForm::begin(['action' => ['calculator/submit-form']]); ?>
		<?= $form->field($model, 'month')->dropDownList([
			'' => '',
			'Январь' => 'Январь',
			'Февраль' => 'Февраль',
			'Август' => 'Август',
			'Сентябрь' => 'Сентябрь',
			'Октябрь' => 'Октябрь',
			'Ноябрь' => 'Ноябрь',
		]) ?>
		<?= $form->field($model, 'rawMaterial')->dropDownList([
			'' => '',
			'Шрот' => 'Шрот',
			'Жмых' => 'Жмых',
			'Соя' => 'Соя',
		]) ?>
		<?= $form->field($model, 'tonnage')->dropDownList([
			'' => '',
			'25' => '25 (т)',
			'50' => '50 (т)',
			'75' => '75 (т)',
			'100' => '100 (т)',
		]) ?>
		<div class="form-group">
			<?= Html::submitButton('Рассчитать', ['class' => 'btn btn-outline-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</body>