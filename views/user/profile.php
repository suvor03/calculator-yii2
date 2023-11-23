<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\User $model */

$this->title = 'Профиль';
?>



<div class="container mt-4 mb-4 p-3 d-flex justify-content-center">
	<div class="card-body p-md-5 mt-5" style="max-width: 600px; border-radius: 50px; background-color: #cce3d7">
		<div class="image d-flex flex-column justify-content-center align-items-center">
			<button class="btn btn-secondary">
				<?php
				$roleImages = [
					'super_admin' => '/img/hacker.png',
					'administrator' => '/img/admin.png',
					'user' => '/img/user.png',
				];

				$user = Yii::$app->user->identity;
				$userId = $user->id;
				$authManager = Yii::$app->authManager;
				$roles = $authManager->getRolesByUser($userId);

				foreach ($roles as $role) {
					echo '<img src="' . $roleImages[$role->name] . '" height="100" width="100" />';
				}
				?>
			</button>
			<?php
			// Выводим имя и почту авторизованного пользователя
			if (!Yii::$app->user->isGuest) {
				$user = Yii::$app->user->identity;
				echo '<p class="name mt-3">' . $user->username . ' - ' . '<span class="email">' . $user->email . '</span></p>';

				// Получаем id пользователя
				$userId = $user->id;

				// Получаем роль пользователя по его id
				$authManager = Yii::$app->authManager;
				$roles = $authManager->getRolesByUser($userId);


				foreach ($roles as $role) {
					echo 'Ваша роль: <span class="fw-bold role">' . $role->name . '</span>';
				}
			}
			?>

			<div class="px-2 rounded mt-4 date">
				<span class="join">Зарегистрировался
					<?= Yii::$app->formatter->asDate($user->created_at, 'dd, MMMM, yyyy') ?>
				</span>
			</div>
		</div>
	</div>
</div>