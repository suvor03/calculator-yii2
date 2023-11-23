<?php
/** @var yii\web\View $this */

use yii\bootstrap5\Alert;

$this->title = 'Домашняя страница';

if (Yii::$app->session->hasFlash('success')) {
	$flashMessage = Yii::$app->session->getFlash('success');
	echo Alert::widget([
		 'options' => $flashMessage['options'],
		 'body' => $flashMessage['message'],
	]);
}
?>

<body>
	<div class="container">
		<div class="row justify-content-center mt-5 pt-5">
			<div class="col-md-6 text-center">
				<h1 class="display-4">Добро пожаловать!</h1>
				<p class="lead">Мы рады вас видеть</p>
			</div>

			<?php echo '<img src="' . Yii::getAlias('@web') . '/img/index.png" alt="Картинка калькулятора" style="max-width: 600px; height: 500px;"'; ?>
		</div>
</body>