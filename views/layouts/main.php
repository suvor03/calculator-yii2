<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
	<title>
		<?= Html::encode($this->title) ?>
	</title>
	<?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100 " style="background-color: #b4dbc6" <?php $this->beginBody() ?> <header
	id="header">
	<?php
	NavBar::begin([
		'brandLabel' => '<img src="' . Yii::getAlias('@web') . '/img/home.png" alt="дом" style="max-width: 50px; height: 40px;">',
		'brandUrl' => Yii::$app->homeUrl,
		'options' => ['class' => 'navbar navbar-expand-lg navbar-dark bg-dark p-3']
	]);


	echo Nav::widget([
		'options' => ['class' => 'navbar-nav ms-auto'],
		'items' => [
			['label' => 'Калькулятор', 'url' => ['/site/calculator'], 'linkOptions' => ['class' => 'btn btn-outline-success text-light mx-5 px-3']],
			Yii::$app->user->isGuest ?
			['label' => 'Войти в систему', 'url' => ['site/auth'], 'linkOptions' => ['class' => 'btn btn-outline-secondary text-light']] :
			[
				'label' => Yii::$app->user->identity->username,
				'items' => [
					['label' => 'Профиль', 'url' => ['user/profile']],
					['label' => 'История расчетов', 'url' => ['calculation/history']],
					(Yii::$app->user->can('administrator') || Yii::$app->user->can('super_admin')) ?
					['label' => 'Пользователи', 'url' => ['user/list']] :

					'<div class="dropdown-divider"></div>',
					['label' => 'Выход', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
				],
				'options' => ['class' => 'nav-item-auth text-center']
			],
		],
	]);
	NavBar::end();
	?>
	</header>

	<main id="main" class="flex-shrink-0" role="main">
		<div class="container">
			<?= $content ?>
		</div>
	</main>

	<footer id="footer" class="footer-dark bg-dark mt-auto py-3" style='background-color: #a2b6df;'>
		<div class="container">
			<div class="row text-muted">
				<div class="col-md-6 text-center text-md-start text-light">&copy;ЭФКО
					Цифровые решения
					<?= date('Y') ?>
				</div>
			</div>
		</div>
	</footer>

	<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>