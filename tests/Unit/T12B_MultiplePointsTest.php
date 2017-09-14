<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T12B_MultiplePointsTest extends T12A_MultiplePointsTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
