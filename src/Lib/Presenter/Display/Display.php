<?php namespace Performance\Lib\Presenter\Display;

use Performance\Lib\Presenter\Formatter;

abstract class Display implements DisplayInterface
{
    protected $pointStage;
    protected $formatter;

    protected $totalTime;
    protected $totalMemory;
    protected $totalMemoryPeak;

    public function __construct()
    {
        $this->formatter = new Formatter();
    }

    public function updateTotalTimeAndMemory()
    {
        $max_time = 0;
        $max_memory = 0;

        foreach ($this->pointStage as $point)
        {
            $max_time += $point->getDifferenceTime();
            $max_memory += $point->getDifferenceMemory();
        }

        $this->totalTime = $max_time;
        $this->totalMemory = $max_memory;
        $this->totalMemoryPeak = memory_get_peak_usage(true);
    }

    public function calculatProcens($pointDifference, $total)
    {
        $upCount = 1000000;

        if($pointDifference > 0)
            return round((100 * $pointDifference * $upCount ) / ($total * $upCount)) ;
        else
            return '0';
    }

}