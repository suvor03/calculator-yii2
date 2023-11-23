<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\AuthForm $model */

use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\History;


$this->title = 'История расчетов';


$dataProvider = new ActiveDataProvider([
	'query' => History::find(), // здесь должен быть ваш запрос для получения истории расчетов
	'pagination' => [
		'pageSize' => 10, // количество строк на одной странице
	],
	'sort' => [ // сортировка по умолчанию
		'defaultOrder' => [
			'id' => SORT_DESC,
		]
	],
]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'columns' => [
		[
			'attribute' => 'id',
			'label' => 'id',
		],
		[
			'attribute' => 'username',
			'visible' => (Yii::$app->user->can('administrator') || Yii::$app->user->can('super_admin')),
			'label' => 'Имя пользователя',
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
		[
			'attribute' => 'created_at',
			'label' => 'Время расчета',
			'format' => ['datetime', 'php:Y-m-d H:i:s'],
		],
	],
]);
?>