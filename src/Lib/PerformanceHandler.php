<?php namespace Performance\Lib;

use Performance\Config;
use Performance\Lib\Holders\QueryLogHolder;

class PerformanceHandler
{
    /*
     * Version
     */
    const VERSION = '1.0.7';

    /*
     * Hold point stack
     */
    private $pointStack = [];

    /*
     *  Hold presenter
     */
    private $presenter;

    /*
     * Hold state of the query log
     *
     * null = not set
     * false = config is false
     * true = query log is set
     */
    public $queryLogState = null;
    public $queryLogStack = [];


    public function __construct()
    {
        // Setup first point
        $this->presenter = new Presenter();

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
        $this->checkQueryLogState();

        // Set label
        if(is_null($label))
            $label = 'Task ' . (count($this->pointStack) - 1);

        // Create point
        $point = new Point($label);

        // Create and add point to stack
        $this->addPointToStack($point);

        // Trigger point
        $this->presenter->startPointTrigger($point);

        // Start point
        $point->start();
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
     * @return mixed
     */
    public function results()
    {
        // Finish all
        $this->finishLastPoint();

        // Add results to presenter
        $this->presenter->displayResults($this->pointStack);
    }

    public function getPoints()
    {
        return $this->pointStack;
    }

//
// PRIVATE
//

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
    private function checkQueryLogState()
    {
        // Check if state is set
        if( ! is_null($this->queryLogState))
            return;

        // Set check query log state
        if(Config::get(Config::QUERY_LOG))
        {
            if( ! class_exists('\Illuminate\Support\Facades\DB'))
                dd('The DB class form Laravel illuminate does not exists. (class_exists(\'\Illuminate\Support\Facades\DB\'))');

            // Setup query log
            try
            {
                \Illuminate\Support\Facades\DB::listen(function ($sql) {$this->queryLogStack[] = new QueryLogHolder($sql);});
                $this->queryLogState = true;
            }
            catch (\RuntimeException $e)
            {
                try
                {
                    \Illuminate\Database\Capsule\Manager::listen(function ($sql) {$this->queryLogStack[] = new QueryLogHolder($sql);});
                    $this->queryLogState = true;
                }
                catch (\RuntimeException $e)
                {
                    $this->queryLogState = false;
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
        if($this->queryLogState !== true)
            return;

        $point->setQueryLog($this->queryLogStack);
        $this->queryLogStack = [];
    }
}