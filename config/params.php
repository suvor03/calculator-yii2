<?php

return [
	'costParams' => [
		'month' => [
			'modelClass' => 'app\models\Months',
			'columnName' => 'name',
			'errorMessage' => "выполнение команды завершено с ошибкой\nне найден прайс для значения --month=",
			'requiredMessage' => "выполнение команды завершено с ошибкой\nнеобходимо ввести месяц",
		],
		'type' => [
			'modelClass' => 'app\models\RawTypes',
			'columnName' => 'name',
			'errorMessage' => "выполнение команды завершено с ошибкой\nне найден прайс для значения --type=",
			'requiredMessage' => "выполнение команды завершено с ошибкой\nнеобходимо ввести тип сырья",
		],
		'tonnage' => [
			'modelClass' => 'app\models\Tonnages',
			'columnName' => 'value',
			'errorMessage' => "выполнение команды завершено с ошибкой\nне найден прайс для значения --tonnage=",
			'requiredMessage' => "выполнение команды завершено с ошибкой\nнеобходимо ввести тоннаж",
		],
	],
];