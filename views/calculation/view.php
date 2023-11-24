<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Детали записи';

echo DetailView::widget([
  'model' => $model,
  'attributes' => [
    'id',
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
      'format' => ['datetime', 'php:Y-m-d H:i:s'],
      'label' => 'Время расчета',
    ],
  ],
]);
?>
<section class="vh-70">
	<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="card-body p-md-5 mt-5" style="max-width: 1000px; border-radius: 50px; background-color: #cce3d7">
				<p class="row d-flex justify-content-center text-center display-6 fw-bold" style="color: #777f7b;">
					Таблица</p>
				<table class="table table-bordered">

				</table>
			</div>
		</div>
	</div>
</section>

<?php
echo Html::a('Назад', ['history'], ['class'=> 'btn btn-primary']);