<?php namespace Unit;

use Performance\Config;
use Performance\Performance;

class T07B_ConfigQueryLogTest extends T07A_ConfigQueryLogTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
