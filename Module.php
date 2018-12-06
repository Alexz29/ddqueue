<?php


namespace ddqueue;


/**
 * Class Module
 *
 * @author Alexey Diveev <alexey@neronium.com>
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'ddqueue\commands';

    public $ddApiKey;

    public $dataProvider;

    public $queue;
}
