<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\bootstrap5\Html;

?>

<section class="vh-70">
	<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="card-body p-md-5 mt-5" style="max-width: 1200px; border-radius: 50px; background-color: #cce3d7">
				<?php
				echo GridView::widget([
					'dataProvider' => new \yii\data\ArrayDataProvider([
						'allModels' => array_filter($users, function ($user) {
							return !in_array('super_admin', $user->getUserRoles());
						})
					]),
					'columns' => [
						[
							'attribute' => 'username',
							'label' => 'Имя пользователя',
						],
						[
							'attribute' => 'email',
							'label' => 'Email',
						],
						[
							'label' => 'Роль',
							'value' => function ($model) {
								return implode(', ', $model->getUserRoles());
							},
						],
						[
							'attribute' => 'created_at',
							'label' => 'Дата регистрации',
							'format' => ['datetime', 'php:Y-m-d H:i:s'],
						],
						[
							'class' => ActionColumn::class,
							'template' => '{update-roles} {update} {delete}',
							'buttons' => [
								'update-roles' => function ($url, $model) {
									if (Yii::$app->user->can('super_admin')) {
										return Html::a('Изменить роль', ['update-roles', 'id' => $model->id], ['class' => 'btn btn-success']);
									}
								},
								'update' => function ($url, $model) {
									return Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
								},
								'delete' => function ($url, $model) {
									return Html::a('Удалить', ['delete', 'id' => $model->id], [
										'class' => 'btn btn-danger',
										'data' => [
											'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
											'method' => 'post',
										],
									]);
								},
							],
						],
					],
				]);
				?>
			</div>
		</div>
	</div>
</section>