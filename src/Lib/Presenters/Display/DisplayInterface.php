<?php namespace Performance\Lib\Presenters\Display;

use Performance\Lib\Point;

interface DisplayInterface
{
    /*
     * Display finish point
     */
    public function displayFinishPoint(Point $point);

    /*
     * Display results
     */
    public function displayResults($pointStack);
}