<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<section class="vh-70">
	<div class="container-fluid h-custom">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="card-body p-md-5 mt-5" style="max-width: 600px; border-radius: 50px; background-color: #cce3d7">

				<?php $form = ActiveForm::begin(); ?>

				<?= $form->field($user, 'username')->label('Имя')->textInput() ?>
				<?= $form->field($user, 'email')->label('Email')->textInput() ?>

				<div class="form-group">
					<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
				</div>

				<?php ActiveForm::end(); ?>

			</div>
		</div>
	</div>
</section>