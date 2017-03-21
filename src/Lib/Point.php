<?php namespace Performance\Lib;


use phpDocumentor\Reflection\Types\Boolean;

class Point
{
    private $active;
    private $label;
    private $startTime;
    private $startMemoryUsage;
    private $stopTime;
    private $stopMemoryUsage;
    private $memoryPeak;
    private $differenceTime;
    private $differenceMemory;

    /**
     * Point constructor.
     * @param $name
     * @param $startTime
     * @param $startMemory
     */
    public function __construct($name, $startTime = null, $startMemory = null)
    {
        // Set items
        $this->setActive(true);
        $this->setLabel($name);
    }

    public function start()
    {
        $this->setStartTime();
        $this->setStartMemoryUsage();
    }

    public function finish()
    {
        $this->setActive(false);
        $this->setStopTime();
        $this->setStopMemoryUsage();
        $this->setMemoryPeak();
        $this->setDifferenceTime();
        $this->setDifferenceMemory();
    }

    public function export()
    {
        return get_object_vars($this);
    }

    // Get and set

    /**
     * @return mixed
     */
    public function getMemoryPeak()
    {
        return $this->memoryPeak;
    }

    /**
     * @param mixed $stopMemoryPeak
     */
    public function setMemoryPeak($memoryPeak = null)
    {
        $this->memoryPeak = ( $memoryPeak ) ? $memoryPeak : memory_get_peak_usage(true);
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getStopTime()
    {
        return $this->stopTime;
    }

    /**
     * @param mixed $stopTime
     */
    public function setStopTime($stopTime = null)
    {
        $this->stopTime = ($stopTime) ? $stopTime : microtime(true);
    }

    /**
     * @return mixed
     */
    public function getStopMemoryUsage()
    {
        return $this->stopMemoryUsage;
    }

    /**
     * @param mixed $stopMemory
     */
    public function setStopMemoryUsage($stopMemoryUsage = null)
    {
        $this->stopMemoryUsage = ($stopMemoryUsage) ? $stopMemoryUsage : memory_get_usage(true);
    }


    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @param mixed $startTime
     */
    public function setStartTime($startTime = null)
    {
        $this->startTime = ( $startTime ) ? $startTime : microtime(true);
    }

    /**
     * @return mixed
     */
    public function getStartMemoryUsage()
    {
        return $this->startMemoryUsage;
    }

    /**
     * @param mixed $startMemory
     */
    public function setStartMemoryUsage($startMemoryUsage = null)
    {
        $this->startMemoryUsage = ( $startMemoryUsage ) ? $startMemoryUsage : memory_get_usage(true);
    }

    /**
     * @return mixed
     */
    public function getDifferenceTime()
    {
        return $this->differenceTime;
    }

    /**
     * @param mixed $differenceTime
     */
    public function setDifferenceTime()
    {
        $this->differenceTime = $this->stopTime - $this->startTime;
    }

    /**
     * @return mixed
     */
    public function getDifferenceMemory()
    {
        return $this->differenceMemory;
    }

    /**
     * @param mixed $differenceMemory
     */
    public function setDifferenceMemory()
    {
        $this->differenceMemory = $this->stopMemoryUsage - $this->startMemoryUsage;
    }




}