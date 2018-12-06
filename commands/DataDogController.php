<?php

namespace ddqueue\commands;

use Bayer\DataDogClient\Client;
use Bayer\DataDogClient\Event;
use Bayer\DataDogClient\Series\Metric;
use ddqueue\components\QueueInfo;
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
        $queue = Yii::$app->get($this->module->queue);
        $this->info = new QueueInfo(new $this->module->dataProvider($queue));
    }


    public function actionIndex()
    {
        $this->pushMetric('yii.queue.delayed', $this->info->provider->getDelayed());
        $this->pushMetric('yii.queue.waiting', $this->info->provider->getWaiting());
        $this->pushMetric('yii.queue.reserved', $this->info->provider->getReserved());
        $this->pushMetric('yii.queue.done', $this->info->provider->getDone());
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
