<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T03B_ConfigConsoleLive extends T03A_ConfigConsoleLive
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
