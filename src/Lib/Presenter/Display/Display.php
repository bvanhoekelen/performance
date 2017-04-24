<?php namespace Performance\Lib\Presenter\Display;

use Performance\Lib\ConfigHandler;
use Performance\Lib\Presenter\Formatter;

abstract class Display implements DisplayInterface
{
    protected $pointStage;
    protected $formatter;

    protected $totalTime;
    protected $totalMemory;
    protected $totalMemoryPeak;
    protected $printStack = [];
    protected $config;

    abstract public function printMessage($message = null);

    /*
     * Replace __CONSTRUCTOR!
     */
    abstract public function bootstrap();

    public function __construct(ConfigHandler $config)
    {
        $this->config = $config;
        $this->formatter = new Formatter();

        $this->bootstrap();
    }

    public function updateTotalTimeAndMemory()
    {
        $max_time = 0;
        $max_memory = 0;

        foreach (array_slice($this->pointStage, 2) as $point)
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

        if($pointDifference > 0 and $total > 0)
            return round((100 * $pointDifference * $upCount ) / ($total * $upCount)) ;
        else
            return '0';
    }

}