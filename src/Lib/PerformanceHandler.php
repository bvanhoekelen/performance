<?php namespace Performance\Lib;

class PerformanceHandler
{
    /*
     * Version
     */
    const VERSION = '1.0.4';

    /*
     * Hold point stack
     */
    private $pointStack = [];

    /*
     *  Hold presenter
     */
    private $presenter;


    public function __construct()
    {
        // Setup first master point
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

}