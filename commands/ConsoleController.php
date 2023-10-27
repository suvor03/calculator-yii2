<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class ConsoleController extends Controller
{
	public $month;
    public $type;
    public $tonnage;
	 
	public function actionCalc()
	{
		$counter = 0;
		$basePath = __DIR__ . '/../runtime/queue.job';
		while (true) {
			echo "Текущая операция: {$counter}" . PHP_EOL;

			if (file_exists($basePath) === true) {
				$data = file_get_contents($basePath);
				echo $data . PHP_EOL;
				unlink($basePath);
			}

			sleep(2);
			$counter++;
		}

		return ExitCode::OK;
	}

	public function options($actionID)
    {
        return ['month', 'type', 'tonnage'];
    }

    public function optionAliases()
    {
        return [
            'month' => 'm',
            'type' => 't',
            'tonnage' => 'tn',
        ];
    }
	 public function actionCost()
    {
        $prices = require(Yii::getAlias('@app/config/prices.php'));

        $priceTable = $prices[$this->type][$this->month];

		  $totalCost = null;
		  foreach ($priceTable as $price) {
			  if (isset($price[$this->tonnage])) {
				  $totalCost = $price[$this->tonnage];
				  break;
			 }
		  }

        if (empty($this->month) || empty($this->type) || empty($this->tonnage)) {
            echo "Ошибка: Все опции обязательны к заполнению.\n";
            return ExitCode::USAGE;
        }

        if (!in_array($this->month, ['Январь', 'Февраль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь'])) {
            echo "Выполнение команды завершено с ошибкой" . PHP_EOL . "некорректное значение месяца.";
            return ExitCode::USAGE;
        }

        if (!in_array($this->type, ['Шрот', 'Жмых', 'Соя'])) {
            echo "Выполнение команды завершено с ошибкой" . PHP_EOL . "некорректное значение типа.";
            return ExitCode::USAGE;
        }

        if (!is_numeric($this->tonnage)) {
            echo "Выполнение команды завершено с ошибкой" . PHP_EOL . "значение тоннажа должно быть числом.";
            return ExitCode::USAGE;
        }

        if (!isset($totalCost)) {
            echo "Выполнение команды завершено с ошибкой" . PHP_EOL . "не найден прайс для значения '--tonnage={$this->tonnage}" . PHP_EOL . "проверьте корректность введенных значений";
            return ExitCode::USAGE;
        }

        echo "введенные параметры:\n";
        echo "месяц: {$this->month}\n";
        echo "тип: {$this->type}\n";
        echo "тоннаж: {$this->tonnage}\n";
		  echo "результат: {$totalCost}\n";

        return ExitCode::OK;
    }
}