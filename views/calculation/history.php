<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\AuthForm $model */

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\History;


$this->title = 'История расчетов';

$dataProvider = new ActiveDataProvider([
	'query' => History::find(),
	'pagination' => [
		'pageSize' => 10,
	],
]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => [
		[
			'attribute' => 'id',
			'label' => 'id',
		],
		[
			'attribute' => 'month_name',
			'label' => 'Месяц',
		],
		[
			'attribute' => 'raw_type_name',
			'label' => 'Тип сырья',
		],
		[
			'attribute' => 'tonnage_value',
			'label' => 'Тоннаж',
		],
		[
			'attribute' => 'price',
			'label' => 'Стоимость',
		],
	],
]);
?>