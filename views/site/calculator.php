<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Month;
use app\models\RawType;
use app\models\Tonnage;

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
		<?= $form->field($model, 'month')->dropDownList(
			ArrayHelper::map(Month::find()->all(), 'name', 'name'),
			['prompt' => '']
		) ?>
		<?= $form->field($model, 'rawType')->dropDownList(
			ArrayHelper::map(RawType::find()->all(), 'name', 'name'),
			['prompt' => '']
		) ?>
		<?= $form->field($model, 'tonnage')->dropDownList(
			ArrayHelper::map(Tonnage::find()->all(), 'value', 'value'),
			['prompt' => '']
		) ?>
		<div class="form-group">
			<?= Html::submitButton('Рассчитать', ['class' => 'btn btn-outline-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</body>