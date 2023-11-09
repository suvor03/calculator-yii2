<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Prices;
use yii\console\ExitCode;
use yii\helpers\Console;

class ConsoleController extends Controller
{
	public ?string $month = null;
	public ?string $type = null;
	public ?int $tonnage = null;

	/**
	 * Summary of actionCalc
	 * @return never
	 */
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
	}

	/**
	 * Summary of options
	 * @param mixed $actionID
	 * @return array
	 */
	public function options($actionID)
	{
		return ['month', 'type', 'tonnage'];
	}

	/**
	 * Summary of actionCalculate
	 * @return int
	 */
	public function actionCalculate()
	{
		$params = require __DIR__ . '/../config/params.php';

		foreach ($params['costParams'] as $param => $data) {
			if ($this->$param === null) {
				$this->stderr($data['requiredMessage'], Console::FG_RED);
				return ExitCode::DATAERR;
			}
			$modelClass = $data['modelClass'];
			if (!$modelClass::find()->where([$data['columnName'] => $this->$param])->exists()) {
				$this->stderr($data['errorMessage'] . $this->$param, Console::FG_RED);
				return ExitCode::DATAERR;
			}
		}

		$result = $this->calculatePrice($this->month, $this->type, $this->tonnage);

		if ($result !== null) {
			if ($this->type == 'Шрот') {
				echo "введенные параметры:\nмесяц - {$this->month}\nтип - {$this->type}\nтоннаж - {$this->tonnage}\nрезультат - $result\n\n{$this->drawMealTable()}";
			} else if ($this->type == 'Жмых') {
				echo "введенные параметры:\nмесяц - {$this->month}\nтип - {$this->type}\nтоннаж - {$this->tonnage}\nрезультат - $result\n\n{$this->drawCakeTable()}";
			} else if ($this->type == "Соя") {
				echo "введенные параметры:\nмесяц - {$this->month}\nтип - {$this->type}\nтоннаж - {$this->tonnage}\nрезультат - $result\n\n{$this->drawSoyTable()}";
			}
			
		}

		return ExitCode::OK;
	}

	/**
	 * Summary of calculatePrice
	 * @param mixed $month
	 * @param mixed $type
	 * @param mixed $tonnage
	 * @return mixed
	 */
	private function calculatePrice($month, $type, $tonnage)
	{
		$result = Prices::find()
			->select('price')
			->innerJoinWith('months')
			->innerJoinWith('rawTypes')
			->innerJoinWith('tonnages')
			->where(['months.name' => $month, 'raw_types.name' => $type, 'tonnages.value' => $tonnage])
			->asArray()
			->one();

		if ($result) {
			return $result['price'];
		} else {
			return null;
		}
	}

	/**
	 * Summary of drawMealTable
	 * @return string
	 */
	private function drawMealTable()
	{
		return "
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| М/Т | Январь | Февраль | Март | Апрель | Май | Июнь | Июль | Август | Сентябрь | Октябрь | Ноябрь | Декабрь |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 25  | 156    | 152     | 103  | 107    | 171 | 156  | 191  | 197    | 166      | 124     | 112    | 139     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 50  | 159    | 149     | 136  | 126    | 170 | 194  | 114  | 165    | 194      | 169     | 148    | 122     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 75  | 148    | 118     | 192  | 123    | 117 | 150  | 153  | 173    | 139      | 124     | 159    | 138     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 100 | 173    | 154     | 126  | 186    | 104 | 145  | 116  | 147    | 117      | 177     | 174    | 159     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		";
	}

	/**
	 * Summary of drawSoyTable
	 * @return string
	 */
	private function drawCakeTable()
	{
		return "
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| М/Т | Январь | Февраль | Март | Апрель | Май | Июнь | Июль | Август | Сентябрь | Октябрь | Ноябрь | Декабрь |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 25  | 157    | 100     | 107  | 160    | 143 | 159  | 198  | 135    | 174      | 156     | 123    | 192     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 50  | 104    | 111     | 140  | 165    | 115 | 142  | 103  | 105    | 117      | 147     | 151    | 186     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 75  | 133    | 157     | 106  | 119    | 162 | 139  | 134  | 115    | 102      | 162     | 181    | 162     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 100 | 172    | 178     | 196  | 170    | 184 | 108  | 173  | 116    | 109      | 115     | 116    | 156     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		";
	}

	/**
	 * Summary of drawSoyTable
	 * @return string
	 */
	private function drawSoyTable()
	{
		return "
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| М/Т | Январь | Февраль | Март | Апрель | Май | Июнь | Июль | Август | Сентябрь | Октябрь | Ноябрь | Декабрь |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 25  | 126    | 151     | 125  | 157    | 180 | 146  | 117  | 160    | 137      | 158     | 136    | 103     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 50  | 154    | 196     | 191  | 104    | 163 | 144  | 145  | 136    | 189      | 162     | 120    | 116     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 75  | 190    | 138     | 122  | 116    | 101 | 113  | 131  | 184    | 129      | 102     | 160    | 145     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		| 100 | 118    | 138     | 102  | 179    | 171 | 194  | 107  | 159    | 129      | 105     | 104    | 165     |
		+-----+--------+---------+------+--------+-----+------+------+--------+----------+---------+--------+---------+
		";
	}
}