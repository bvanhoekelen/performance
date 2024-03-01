<?php namespace Unit;

use Performance\Config;
use Performance\Performance;
use PHPUnit\Framework\TestCase;

class T13A_PreventClearScreenTest extends TestCase
{
    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    public function testConfigRunInformation()
    {
        $this->setTestUp();

        Config::setClearScreen(false);

        // Start multiple point 1
        Performance::point();
        Performance::results();
    }

    public function testPointLabelNiceFunction()
    {

	    $configItem = Performance::instance()->config->isClearScreen();
	    $this->assertFalse($configItem);

    }
}
