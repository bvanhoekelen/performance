<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T09B_ConfigNiceLabelTest extends T09A_ConfigNiceLabelTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
