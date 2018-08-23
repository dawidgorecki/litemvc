<?php

namespace Libraries\Utilities;

class ExecutionTimeUtils
{
    /**
     * @var float
     */
    private $startTime;

    /**
     * @var float
     */
    private $endTime;

    public function start(): void
    {
        $this->startTime = microtime(true);
    }

    public function end(): void
    {
        $this->endTime = microtime(true);
    }

    /**
     * @return float
     */
    public function diff(): float
    {
        return $this->endTime - $this->startTime;
    }

}
