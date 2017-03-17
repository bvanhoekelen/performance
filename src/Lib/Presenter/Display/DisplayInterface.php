<?php namespace Performance\Lib\Presenter\Display;

use Performance\Lib\Point;

interface DisplayInterface
{
    /*
     * Display start point
     */
    public function displayStartPoint(Point $point);

    /*
     * Display finish point
     */
    public function displayFinishPoint(Point $point);

    /*
     * Display results
     */
    public function displayResults(Point $masterPoint, $pointStack);
}