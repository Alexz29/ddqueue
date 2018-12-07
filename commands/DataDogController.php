<?php

namespace ddqueue\commands;

use Bayer\DataDogClient\Client;
use Bayer\DataDogClient\Event;
use Bayer\DataDogClient\Series\Metric;
use ddqueue\components\QueueInfo;
use yii\helpers\Console;
use yii\helpers\Url;
use Yii;


/**
 * Class DataDogController
 *
 * @property \ddqueue\Module $module
 *
 * @author Alexey Diveev <alexey@neronium.com>
 */
class DataDogController extends \yii\console\Controller
{

    public $info;

    public $host;

    public $client;

    public function init()
    {
        $this->host = gethostname();
        $this->client = new Client($this->module->ddApiKey);
    }


    public function actionSend($queueName = null)
    {
        if (!$queueName) {
            $queueName = $this->module->queue;
        }

        try {
            $queue = Yii::$app->get($queueName);
        } catch (\Exception $e) {
            $this->stdout($e->getMessage() . "\n", Console::FG_RED);
            return false;
        }

        $this->info = new QueueInfo(new $this->module->dataProvider($queue));

        $this->pushMetric("yii.queue.$queueName.delayed", $this->info->provider->getDelayed());
        $this->stdout("yii.queue.$queueName.delayed sent" . "\n", Console::FG_GREEN);

        $this->pushMetric("yii.queue.$queueName.waiting", $this->info->provider->getWaiting());
        $this->stdout("yii.queue.$queueName.waiting sent" . "\n", Console::FG_GREEN);

        $this->pushMetric("yii.queue.$queueName.reserved", $this->info->provider->getReserved());
        $this->stdout("yii.queue.$queueName.reserved sent" . "\n", Console::FG_GREEN);

        $this->pushMetric("yii.queue.$queueName.done", $this->info->provider->getDone());
        $this->stdout("yii.queue.$queueName.done sent" . "\n", Console::FG_GREEN);
        $this->stdout('Done ...' . "\n", Console::FG_CYAN);
    }

    protected function pushMetric($name, $value)
    {
        $metric = new Metric($name, [
            [time(), $value],
        ]);
        $metric->setHost($this->host);
        $this->client->sendMetric($metric);
    }
}
