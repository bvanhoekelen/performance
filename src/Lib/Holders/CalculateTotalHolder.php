<?php namespace Performance\Lib\Holders;

class CalculateTotalHolder
{
    public $totalTime;
    public $totalMemory;
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