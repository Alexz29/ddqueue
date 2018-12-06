<?php

namespace ddqueue\interfaces;


/**
 * Interface DriverQueueInterface
 * @author Alexey Diveev <alexey@neronium.com>
 */
interface DataProviderQueueInterface
{
    /**
     * @return int
     */
    public function getWaiting(): int;

    /**
     * @return int
     */
    public function getDelayed(): int;

    /**
     * @return int
     */
    public function getReserved(): int;

    /**
     * @return mixed
     */
    public function getDone():int;
}
