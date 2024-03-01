<?php namespace Unit;

use Performance\Config;
use Performance\Performance;

class T05B_ConfigEnableToolTest extends T05A_ConfigEnableToolTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
