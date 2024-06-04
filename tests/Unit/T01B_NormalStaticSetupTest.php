<?php namespace Unit;

use Performance\Config;
use Performance\Performance;

class T01B_NormalStaticSetupTest extends T01A_NormalStaticSetupTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
