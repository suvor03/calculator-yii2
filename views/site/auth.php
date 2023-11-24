<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\AuthForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\bootstrap5\Alert;

$this->title = 'Авторизация';

if (Yii::$app->session->hasFlash('error')) {
	$errorMessage = Yii::$app->session->getFlash('error');
	echo Alert::widget([
		'options' => ['class' => 'alert-danger alert-dismissible'],
		'body' => $errorMessage,
	]);
}
?>

<section class="vh-70">
	<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="card-body p-md-5 mt-5" style="max-width: 1000px; border-radius: 50px; background-color: #cce3d7">
				<p class="row d-flex justify-content-center text-center display-4 fw-bold" style="color: #777f7b;">
					Авторизация</p>
				<div class="row justify-content-center">
					<div class="col-md-9 col-lg-6 col-xl-5">

						<img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
							class="img-fluid" alt="Sample image">
					</div>

					<div class="p-md-2 mt-5 col-lg-6 col-xl-4 offset-xl-1">
						<?php $form = ActiveForm::begin(); ?>

						<?= $form->field($model, 'email')->label('Логин')->textInput(['class' => 'form-control form-control-lg', 'placeholder' => 'Введите email']) ?>

						<?= $form->field($model, 'password')->label('Пароль')->passwordInput(['class' => 'form-control form-control-lg', 'placeholder' => 'Введите пароль']) ?>

						<div class="d-flex justify-content-center mt-4">
							<?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'style' => 'padding-left: 2.5rem; padding-right: 2.5rem;']) ?>
						</div>

						<p class="small fw-bold text-center mt-2 pt-1 mb-0">Нет аккаунта?
							<?= Html::a('Регистрация', 'http://calculator/site/login', ['class' => 'link-danger']) ?>
						</p>

						<?php ActiveForm::end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>