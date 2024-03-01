<?php namespace Unit;

use Performance\Config;
use Performance\Performance;

class T04B_ConfigTrimTest extends T04A_ConfigTrimTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
