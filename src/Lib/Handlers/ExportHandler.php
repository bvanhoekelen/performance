<?php namespace Performance\Lib\Handlers;

class ExportHandler
{
    protected $performance;
    protected $returnItem;

    protected $points;
    protected $config;

    public function __construct(PerformanceHandler $performance)
    {
        $this->performance = $performance;
    }

    protected function checkIfAllIsSet()
    {
        if( $this->returnItem )
            return;

        $this->config();
        $this->points();

        $this->returnItem = [];
        $this->returnItem['config'] = $this->config;
        $this->returnItem['points'] = $this->points;
    }

    protected function resetItems()
    {
        $this->points = null;
        $this->config = null;
        $this->returnItem = null;
    }

    public function points()
    {
        $this->points = $this->performance->getPoints();
        $this->returnItem = $this->points;
        return $this;

    }

    public function config()
    {
        $this->config = $this->performance->config;
        $this->returnItem = $this->config;
        return $this;
    }

    public function get()
    {
        $this->checkIfAllIsSet();
        $return = $this->returnItem;
        $this->resetItems();
        return $return;
    }

    public function toFile($file)
    {
        return file_put_contents($file, $this->toJson());
    }

    public function toJson()
    {
        $return = [];
        $multiExport = false;

        // Set items
        $this->checkIfAllIsSet();

        // Check if it is one or many to export
        if($this->config and $this->points)
            $multiExport = true;

        // Config
        if($this->config)
        {
            if($multiExport)
                $return['config'] = $this->config->export();
            else
                $return = $this->config->export();
        }

        // Points
        if($this->points)
        {
            $points = [];
            foreach ($this->points as $point)
            {
                $points[] = $point->export();
            }

            if($multiExport)
                $return['points'] = $points;
            else
                $return = $points;
        }

        // Reset
        $this->resetItems();

        // Return
        return json_encode($return);
    }
}
