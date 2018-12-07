Yii2 DataDog Queue 
==================
Extension yii2 send metrics about queue to dataDog

Metrics:
```
yii.{name of your Queue}.waiting
yii.{name of your Queue}.delayed
yii.{name of your Queue}.reserved
yii.{name of your Queue}.done
```

For current host.

Support Redis Queue ONLY!!!

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist alexz29/yii2-ddqueue "*"
```

or add

```
"alexz29/yii2-ddqueue": "*"
```

to the require section of your `composer.json` file.


Usage
-----

add to config/console.php

```
 'ddqueue' => [
    'class' => 'ddqueue\Module',
    'ddApiKey' => '{api_key}',  //your api key from dataDog
    'dataProvider'=> \ddqueue\providers\RedisProvider::class, // data provider class
    'queue' => 'queueSingleThread'  //name of components yours queue by default
 ],
```


example your queue cfg:
```
 'queueSingleThread' => [
      'class' => 'yii\queue\redis\Queue',
      'redis' => ['class' => 'yii\redis\Connection'],
      'channel' => 'queueSingleThread',
      'as log' => [
           'class' => 'yii\queue\LogBehavior',
      ]
   ],
```

Cli command:

send information about queue from config 'queue' => 'queueSingleThread'
```
php yii ddqueue/data-dog/send
```

Also you can provide Queue from console example:
```
php yii ddqueue/data-dog/send queueSingleThread
```

Result:
```
yii.queueSingleThread.delayed sent
yii.queueSingleThread.waiting sent
yii.queueSingleThread.reserved sent
yii.queueSingleThread.done sent
Done ...
```
