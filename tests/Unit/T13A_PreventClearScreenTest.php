<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T13A_PreventClearScreenTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigRunInformation()
    {
        $this->setTestUp();

        Config::setClearScreen(false);

        // Start multiple point 1
        Performance::point();
        Performance::results();
    }

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    public function testPointLabelNiceFunction()
    {

        $configItem = Performance::instance()->config->isClearScreen();
        $this->assertFalse($configItem);

    }
}
