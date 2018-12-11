<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T13A_PreventClearScreenTest extends \PHPUnit_Framework_TestCase
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
