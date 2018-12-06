<?php

namespace ddqueue\providers;

use ddqueue\interfaces\DataProviderQueueInterface;
use Yii;
use yii\queue\redis\Queue;

/**
 * Class Redis
 *
 * @author Alexey Diveev <alexey@neronium.com>
 */
class RedisProvider implements DataProviderQueueInterface
{

    /**
     * @var
     */
    public $queue;
    /**
     * @var
     */
    public $waiting;
    /**
     * @var
     */
    public $delayed;
    /**
     * @var
     */
    public $reserved;
    /**
     * @var
     */
    public $done;

    /**
     * RedisProvider constructor.
     * @param $queue
     */
    public function __construct(Queue $queue)
    {
        $this->queue = $queue;
        $prefix = $this->queue->channel;
        $this->waiting = $this->queue->redis->llen("$prefix.waiting");
        $this->delayed = $this->queue->redis->zcount("$prefix.delayed", '-inf', '+inf');
        $this->reserved = $this->queue->redis->zcount("$prefix.reserved", '-inf', '+inf');
        $total = $this->queue->redis->get("$prefix.message_id");
        $this->done = $total - $this->waiting - $this->delayed - $this->reserved;
    }

    /**
     * @return int
     */
    public function getWaiting(): int
    {
        return $this->waiting;
    }

    /**
     * @return int
     */
    public function getDelayed(): int
    {
        return $this->delayed;
    }

    /**
     * @return int
     */
    public function getReserved(): int
    {
        return $this->reserved;
    }

    /**
     * @return int
     */
    public function getDone(): int
    {
        return $this->done;
    }

}
