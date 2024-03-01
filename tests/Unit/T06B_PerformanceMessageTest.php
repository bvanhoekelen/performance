<?php namespace Unit;

use Performance\Config;
use Performance\Performance;

class T06B_PerformanceMessageTest extends T06A_PerformanceMessageTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
