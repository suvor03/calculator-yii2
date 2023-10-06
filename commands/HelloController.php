<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        $counter = 0;
        $basePath = __DIR__ . '/../runtime/queue.job';
        while (true)
        {           
            echo 'Текущая итерация: ' . $counter . PHP_EOL;
            
            if (file_exists($basePath) === true)
            {
                $data = file_get_contents($basePath);
                echo $data . PHP_EOL;
                unlink($basePath);
            }
            
            sleep(1);
            $counter++;
        }

        return ExitCode::OK;
    }
}
