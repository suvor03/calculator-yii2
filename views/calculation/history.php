<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\AuthForm $model */

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;

$this->title = 'История расчетов';

$user = Yii::$app->user->getIdentity();
$username = $user->username;

if (Yii::$app->user->can('user')) {
	$dataProvider->query->andFilterWhere(['username' => $username]);
}

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
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
		[
			'class' => ActionColumn::class,
			'template' => '{view} {delete}',
			'visibleButtons' => [
				'delete' => (Yii::$app->user->can('administrator') || Yii::$app->user->can('super_admin')),
			],
			'buttons' => [
				'view' => function ($url, $model) {
					return Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']);
				 },
				'delete' => function ($url, $model) {
					return Html::a('Удалить', ['delete', 'id' => $model->id], [
						'class' => 'btn btn-danger',
						'data' => [
							'confirm' => 'Вы уверены, что хотите удалить эту запись?',
							'method' => 'post',
						],
					]);
				},
			],
		],
	],
]);

echo LinkPager::widget([
	'pagination' => $dataProvider->pagination,
	'options' => ['class' => 'pagination justify-content-center'],
	'linkContainerOptions' => ['class' => 'page-item'],
	'linkOptions' => ['class' => 'page-link'],
]);