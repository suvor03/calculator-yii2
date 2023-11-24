<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Регистрация';
?>

<section class="vh-70">
	<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="card-body p-md-5 mt-1" style="max-width: 700px; border-radius: 50px; background-color: #cce3d7">
				<p class="row d-flex justify-content-center text-center display-4 fw-bold" style="color: #777f7b;">
					Регистрация</p>
				<div class="row justify-content-center">

					<?php $form = ActiveForm::begin(['class' => 'text-center']); ?>

					<?= $form->field($model, 'username')->textInput(['class' => 'form-control', 'placeholder' => 'Введите имя'])->label('Имя') ?>

					<?= $form->field($model, 'email')->textInput(['class' => 'form-control', 'placeholder' => 'Введите email'])->label('Email') ?>

					<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control', 'placeholder' => 'Введите пароль'])->label('Пароль') ?>

					<?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'form-control', 'placeholder' => 'Введите пароль'])->label('Повторите пароль') ?>

					<div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
						<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
					</div>

					<?php ActiveForm::end(); ?>

					<div class="col-xl-4">
						<img src="/img/login.png" class="img-fluid" alt="картинка замка"
							style="margin-left: 45px; max-height: 80px">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>