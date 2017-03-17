<?php namespace Performance\Lib;


class PerformanceHandler
{
    /*
     * Version
     */
    const VERSION = '0.01';

    /*
     * Hold point stack
     */
    private $pointStack = [];

    /*
     * Hold Point form the first to last measuring point
     */
    private $masterPoint;

    /*
     *  Hold presenter
     */
    private $presenter;


    public function __construct()
    {
        // Setup first master point
        $this->masterPoint = new Point('start');
        $this->presenter = new Presenter();
    }

    /*
     * Set measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public function point($label = null)
    {
        if( ! $label)
        {
            $this->finishAll();
            $label = 'Task ' . (count($this->pointStack) + 1);
        }

        // Create point
        $point = new Point($label);

        // Create and add point to stack
        $this->addPointToStack($point);

        // Trigger point
        $this->presenter->startPointTrigger($point);

        return $point;

    }

    /*
     * Finish measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public function finish($label = null)
    {
        if($label)
            $this->finishPointByLabel($label);
        else
            $this->finishAll();
    }

    /*
     * Return test results
     *
     * @param array|[]   $config
     * @return mixed
     */
    public function results(array $config = [])
    {
        // Finish all
        $this->finishAll();

        // Close master point
        $this->masterPoint->finish();

        // Add results to presenter
        $this->presenter->displayResults($this->masterPoint, $this->pointStack);
    }

    public function getPoints()
    {
        return $this->pointStack;
    }

    public function getMasterPoint()
    {
        return $this->masterPoint;
    }

    // Private

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
    private function finishAll()
    {
        foreach ($this->pointStack as $pointId => $point)
        {
            if($point->isActive())
                $this->finishPoint($point);
        }
    }

    /*
     * Finish point by label in the stack
     *
     * @param string    $label (point label)
     *
     * @return Boolean
     */
    private function finishPointByLabel($label)
    {
        $findLabel = false;
        foreach ($this->pointStack as $pointId => $point)
        {
            if($pointId == $label)
            {
                $findLabel = true;
                $this->finishPoint($point);
                break;
            }
        }

        return $findLabel;
    }

    private function finishPoint(Point $point)
    {
        // Finish point
        $point->finish();

        // Trigger presenter listener
        $this->presenter->finishPointTrigger($point);
    }

}