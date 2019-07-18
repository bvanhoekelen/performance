<?php

declare(strict_types=1);

namespace Performance\Lib;

use Performance\Lib\Handlers\ConfigHandler;
use Performance\Lib\Interfaces\ExportInterface;

/**
 * Class Point
 * @package Performance\Lib
 */
class Point implements ExportInterface
{
    /**
     *
     */
    const POINT_PRELOAD = '__POINT_PRELOAD';
    /**
     *
     */
    const POINT_MULTIPLE_PRELOAD = '__MULTIPLE_POINT_PRELOAD';
    /**
     *
     */
    const POINT_CALIBRATE = 'Calibrate point';

    /**
     * @var ConfigHandler
     */
    protected $config;

    /**
     * @var
     */
    protected $isMultiplePoint;

    /**
     * @var
     */
    protected $active;

    /**
     * @var
     */
    protected $label;

    /**
     * @var
     */
    protected $startTime;

    /**
     * @var
     */
    protected $startMemoryUsage;

    /**
     * @var
     */
    protected $stopTime;

    /**
     * @var
     */
    protected $stopMemoryUsage;

    /**
     * @var
     */
    protected $memoryPeak;

    /**
     * @var
     */
    protected $differenceTime;

    /**
     * @var
     */
    protected $differenceMemory;

    /**
     * @var array
     */
    protected $queryLog = [];

    /**
     * @var array
     */
    protected $newLineMessage = [];

    /**
     * Point constructor.
     * @param ConfigHandler $config
     * @param $name
     * @param $isMultiplePoint
     */
    public function __construct(ConfigHandler $config, $name, $isMultiplePoint)
    {
        // Set items
        $this->config = $config;
        $this->setLabel($name);
        $this->setIsMultiplePoint($isMultiplePoint);
    }

    /**
     * @param boolean $isMultiplePoint
     */
    public function setIsMultiplePoint($isMultiplePoint)
    {
        $this->isMultiplePoint = (boolean)$isMultiplePoint;
    }

    /**
     * Start point
     *
     * return void
     */
    public function start()
    {
        $this->setActive(true);
        $this->setStartTime();
        $this->setStartMemoryUsage();
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    // Get and set

    /**
     * Finish point
     *
     * return void
     */
    public function finish()
    {
        $this->setActive(false);
        $this->setStopTimeIfNotExists();
        $this->setStopMemoryUsage();
        $this->setMemoryPeak();
        $this->setDifferenceTime();
        $this->setDifferenceMemory();
    }

    /**
     * @param mixed $stopTime
     */
    public function setStopTimeIfNotExists($stopTime = null)
    {
        if (is_null($this->stopTime)) {
            $this->setStopTime($stopTime);
        }
    }

    /**
     * Simple export function
     */
    public function export(): array
    {
        $vars = get_object_vars($this);
        unset($vars[ 'config' ]); // skip config

        return $vars ?? [];
    }

    /**
     * @return mixed
     */
    public function getMemoryPeak()
    {
        return $this->memoryPeak;
    }

    /**
     * @param int $memoryPeak
     */
    public function setMemoryPeak(int $memoryPeak = null)
    {
        $this->memoryPeak = ($memoryPeak) ? $memoryPeak : memory_get_peak_usage(true);
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
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
     * @param null $stopMemoryUsage
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
        // Run ltrim
        $configLTrim = $this->config->getPointLabelLTrim();
        if ($configLTrim) {
            $label = ltrim($label, $configLTrim);
        }

        // Run Rtrim
        $configRTrim = $this->config->getPointLabelRTrim();
        if ($configRTrim) {
            $label = rtrim($label, $configRTrim);
        }

        // Set nice label
        if ($label !== static::POINT_PRELOAD && $label !== static::POINT_MULTIPLE_PRELOAD && $this->config->isPointLabelNice()) {
            $label = ucfirst(str_replace('  ', ' ', preg_replace('/(?<!^)[A-Z]/', ' $0', $label)));
        }

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
        $this->startTime = ($startTime) ? $startTime : microtime(true);
    }

    /**
     * @return mixed
     */
    public function getStartMemoryUsage()
    {
        return $this->startMemoryUsage;
    }

    /**
     * @param null $startMemoryUsage
     */
    public function setStartMemoryUsage($startMemoryUsage = null)
    {
        $this->startMemoryUsage = ($startMemoryUsage) ? $startMemoryUsage : memory_get_usage(true);
    }

    /**
     * @return mixed
     */
    public function getDifferenceTime()
    {
        return $this->differenceTime;
    }

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

    public function setDifferenceMemory()
    {
        $difference = $this->stopMemoryUsage - $this->startMemoryUsage;
        $this->differenceMemory = ($difference > 0) ? $difference : 0;
    }

    /**
     * @return array
     */
    public function getQueryLog()
    {
        return $this->queryLog;
    }

    /**
     * @param array $queryLog
     */
    public function setQueryLog($queryLog)
    {
        $this->queryLog = $queryLog;
    }

    /**
     * @return array
     */
    public function getNewLineMessage()
    {
        return $this->newLineMessage;
    }

    /**
     * @param string $newLineMessage
     */
    public function addNewLineMessage($newLineMessage)
    {
        $this->newLineMessage[] = $newLineMessage;
    }

    /**
     * @return boolean
     */
    public function isMultiplePoint()
    {
        return $this->isMultiplePoint;
    }
}
