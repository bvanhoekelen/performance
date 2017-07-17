<?php namespace Performance\Lib\Handlers;

use Performance\Lib\Holders\QueryLogHolder;
use Performance\Lib\Point;
use Performance\Lib\Presenters\ConsolePresenter;
use Performance\Lib\Presenters\Presenter;
use Performance\Lib\Presenters\WebPresenter;

class PerformanceHandler
{
    /*
     * Version
     */
    const VERSION = '2.2.0';

    /*
     * Hold point stack
     */
    private $pointStack = [];

    /*
     *  Hold presenter
     */
    private $presenter;

    /*
     * Hold the query log items
     */
    public $queryLogStack = [];

    /*
     * Hold the config class
     */
    public $config;

    /*
     *
     */
    private $messageToLabel = null;

    public function __construct()
    {
        // Set config
        $this->config = new ConfigHandler();
    }

    public function bootstrap()
    {
        $this->setConfigQueryLogState();

        // Set display
        $this->bootstrapDisplay();

        // Preload class point
        $this->preload();
    }

    /*
     * Set measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public function point($label = null)
    {
        // Check if point already exists
        $this->finishLastPoint();
        $this->checkIfPointLabelExists($label);

        // Set label
        if(is_null($label))
            $label = 'Task ' . (count($this->pointStack) - 1);

        // Create point
        $point = new Point($this->config, $label);

        // Create and add point to stack
        $this->addPointToStack($point);

        // Start point
        $point->start();
    }

    /*
     * Set message
     *
     * @param string|null   $message
     * @param boolean|null   $newLine
     * @return void
     */
    public function message($message, $newLine = true)
    {
        $point = end($this->pointStack);

        // Skip
        if( ! $point or ! $point->isActive())
            return;

        if($newLine)
            $point->addNewLineMessage($message);
        else
            $this->messageToLabel .= $message;
    }

    /*
     * Finish measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public function finish()
    {
        $this->finishLastPoint();
    }

    /*
     * Return test results
     *
     * @return Performance\Lib\Handlers\ExportHandler
     */
    public function results()
    {
        // Finish all
        $this->finishLastPoint();

        // Add results to presenter
        $this->presenter->displayResultsTrigger($this->pointStack);

        // Return export
        return $this->export();
    }

    public function export()
    {
        return new ExportHandler($this);
    }

    public function getPoints()
    {
        return $this->pointStack;
    }

//
// PRIVATE
//

    private function bootstrapDisplay()
    {
        if($this->config->getPresenter() == Presenter::PRESENTER_CONSOLE)
            $this->presenter = new ConsolePresenter($this->config);
        elseif($this->config->getPresenter() == Presenter::PRESENTER_WEB)
            $this->presenter = new WebPresenter($this->config);
        else
            dd('Unknown presenter ', $this->config->getPresenter());
    }

    /*
     * Add point to stack
     *
     * @param Point   $point
     * @return void
     */
    private function addPointToStack(Point $point)
    {
        $this->pointStack[] = $point;
    }

    /*
     * Finish all point in the stack
     *
     * @return void
     */
    private function finishLastPoint()
    {
        if(count($this->pointStack))
        {
            // Get point
            $point = end($this->pointStack);

            if($point->isActive())
            {
                // Set query log items
                $this->setQueryLogItemsToPoint($point);

                // Check if message in label text
                $this->checkAndSetMessageInToLabel($point);

                // Finish point
                $point->finish();

                // Trigger presenter listener
                $this->presenter->finishPointTrigger($point);
            }
        }
    }

    private function checkIfPointLabelExists($label)
    {
        $labelExists = false;
        foreach ($this->pointStack as $point)
        {
            if($point->getLabel() == $label)
            {
                $labelExists = true;
                break;
            }
        }

        if($labelExists)
            dd(" Label " . $label . " already exists! Choose new point label." );
    }

    /*
     * Preload wil setup te point class
     */
    private function preload()
    {
        $this->point( Point::POINT_PRELOAD );
        $this->point( Point::POINT_CALIBRATE );
    }

    /*
     * Check if query log is possible
     */
    private function setConfigQueryLogState()
    {
        // Check if state is set
        if( ! is_null($this->config->queryLogState))
            return;

        // Set check query log state
        if($this->config->isQueryLog())
        {
            $this->config->queryLogState = false;

            // Check if DB class exists
            if( ! class_exists('\Illuminate\Support\Facades\DB'))
                return;

            // Resister listener
            try
            {
                \Illuminate\Support\Facades\DB::listen(function ($sql) {$this->queryLogStack[] = new QueryLogHolder($sql);});
                $this->config->queryLogState = true;
            }
            catch (\RuntimeException $e)
            {
                try
                {
                    \Illuminate\Database\Capsule\Manager::listen(function ($sql) {$this->queryLogStack[] = new QueryLogHolder($sql);});
                    $this->config->queryLogState = true;

                }
                catch (\RuntimeException $e)
                {
                    $this->config->queryLogState = false;
                }
            }
        }
    }

    /*
     * Move query log items to point
     */
    private function setQueryLogItemsToPoint(Point $point)
    {
        // Skip if query log is disabled
        if($this->config->queryLogState !== true)
            return;

        $point->setQueryLog($this->queryLogStack);
        $this->queryLogStack = [];
    }

    /*
     * Update point label with message
     */
    private function checkAndSetMessageInToLabel(Point $point)
    {
        if( ! $this->messageToLabel)
            return;

        // Update label
        $point->setLabel( $point->getLabel() . " - " . $this->messageToLabel);

        // Reset
        $this->messageToLabel = '';
    }
}