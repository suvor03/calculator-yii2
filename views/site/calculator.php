<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'Calculator'; 
$this->params['breadcrumbs'][] = $this->title;
?>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
	<div class="site-calculator">
		<h1><?= Html::encode($this->title) ?></h1> <br>

		<div class="container">
			<form action="">

				<div class="form-group">
        			<label for="list1">месяц:</label>
        			<select class="form-control" id="list1">
						<option>Январь</option>
						<option>Февраль</option>
						<option>Август</option>
						<option>Сентябрь</option>
						<option>Октябрь</option>
						<option>Ноябрь</option>
        			</select>
      		</div>

      		<div class="form-group">
					<label for="list2">тип сырья:</label>
					<select class="form-control" id="list2">
							<option>Шрот</option>
							<option>Жмых</option>
							<option>Соя</option>
					</select>
      		</div>

				<div class="form-group">
					<label for="list3">тоннаж:</label>
					<select class="form-control" id="list3">
							<option>25 (т)</option>
							<option>50 (т)</option>
							<option>75 (т)</option>
							<option>100 (т)</option>
					</select>
				</div>
							
				<button type="button" class="btn btn-outline-primary">Рассчитать</button>				
			</form> 
		</div>		
	</div>
</body>