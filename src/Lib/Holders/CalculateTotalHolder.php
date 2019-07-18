<?php

declare(strict_types=1);

namespace Performance\Lib\Holders;

/**
 * Class CalculateTotalHolder
 * @package Performance\Lib\Holders
 */
class CalculateTotalHolder
{
    /**
     * @var
     */
    public $totalTime;

    /**
     * @var
     */
    public $totalMemory;

    /**
     * @var
     */
    public $totalMemoryPeak;

    /**
     * CalculateTotalHolder constructor.
     * @param $totalTime
     * @param $totalMemory
     * @param $totalMemoryPeak
     */
    public function __construct($totalTime, $totalMemory, $totalMemoryPeak)
    {
        $this->totalTime = $totalTime;
        $this->totalMemory = $totalMemory;
        $this->totalMemoryPeak = $totalMemoryPeak;
    }
}