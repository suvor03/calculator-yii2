<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Результат расчета:';
$this->params['breadcrumbs'][] = $this->title;
?>

<body>
	<div class="result-cost">
		<h1>
			<?= Html::encode($this->title) ?>
		</h1>

		<table class="table table-dark table-striped">
			<thead>
				<tr>
					<th scope="col">Материал</th>
					<th scope="col">Месяц</th>
					<th scope="col">Тоннаж</th>
					<th scope="col">Итоговая стоимость</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<?= $rawMaterial ?>
					</td>
					<td>
						<?= $month ?>
					</td>
					<td>
						<?= $tonnage ?>
					</td>
					<td class="table-danger">
						<?= $totalCost ?>
					</td>
				</tr>
		</table>

	</div>
</body>