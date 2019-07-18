<?php

declare(strict_types=1);

namespace Performance\Lib\Handlers;

use Performance\Lib\Point;

/**
 * Class ExportHandler
 * @package Performance\Lib\Handlers
 */
class ExportHandler
{
    /**
     * @var PerformanceHandler
     */
    protected $performance;

    /**
     * @var
     */
    protected $returnItem;

    /**
     * @var Point[]
     */
    protected $points;

    /**
     * @var ConfigHandler
     */
    protected $config;

    /**
     * ExportHandler constructor.
     * @param PerformanceHandler $performance
     */
    public function __construct(PerformanceHandler $performance)
    {
        $this->performance = $performance;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $this->checkIfAllIsSet();
        $return = $this->returnItem;
        $this->resetItems();
        return $return;
    }

    /**
     *
     */
    protected function checkIfAllIsSet()
    {
        if ($this->returnItem) {
            return;
        }

        $this->config();
        $this->points();

        $this->returnItem = [];
        $this->returnItem[ 'config' ] = $this->config;
        $this->returnItem[ 'points' ] = $this->points;
    }

    /**
     * @return $this
     */
    public function config()
    {
        $this->config = $this->performance->config;
        $this->returnItem = $this->config;
        return $this;
    }

    /**
     * @return $this
     */
    public function points()
    {
        $this->points = $this->performance->getPoints();
        $this->returnItem = $this->points;
        return $this;

    }

    /**
     *
     */
    protected function resetItems()
    {
        $this->points = null;
        $this->config = null;
        $this->returnItem = null;
    }

    /**
     * @param $file
     * @return bool|int
     */
    public function toFile($file)
    {
        return file_put_contents($file, $this->toJson());
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        $return = [];
        $multiExport = false;

        // Set items
        $this->checkIfAllIsSet();

        // Check if it is one or many to export
        if ($this->config && $this->points) {
            $multiExport = true;
        }

        // Config
        if ($this->config) {
            if ($multiExport) {
                $return[ 'config' ] = $this->config->export();
            } else {
                $return = $this->config->export();
            }
        }

        // Points
        if ($this->points) {
            $exported = [];
            foreach ($this->points as $point) {
                $exported[] = $point->export();
            }

            if ($multiExport) {
                $return[ 'points' ] = $exported;
            } else {
                $return = $exported;
            }
        }

        // Reset
        $this->resetItems();

        // Return
        return json_encode($return);
    }
}
