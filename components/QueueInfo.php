<?php

namespace ddqueue\components;

use ddqueue\interfaces\DataProviderQueueInterface;

/**
 * Class QueueInfo
 *
 * @author Alexey Diveev <alexey@neronium.com>
 */
class QueueInfo
{
    public $provider;

    public function __construct(DataProviderQueueInterface $provider)
    {
        $this->provider = $provider;
    }
}
