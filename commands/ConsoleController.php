<?php 

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

class ConsoleController extends Controller
{
	public function actionCalc()
	{
		$counter = 0;
		$basePath = __DIR__ . '/../runtime/queue.job';
		while(true) {
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
}