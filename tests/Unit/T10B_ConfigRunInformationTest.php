<?php namespace Unit;

use Performance\Config;
use Performance\Performance;

class T10B_ConfigRunInformationTest extends T10A_ConfigRunInformationTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
