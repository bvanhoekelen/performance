<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T03A_ConfigConsoleLive extends \PHPUnit_Framework_TestCase
{
    public function testSetConfigItemConsoleLive()
    {
        // Reset
        Performance::instanceReset();

        // Set config item live
        Config::setConsoleLive(true);

        // Set point
        Performance::point('Config console live');

        // Task
        usleep(2000);

        // Print results
        Performance::results();
    }

    public function testConfigItemConsoleLiveIsTrue()
    {
        $config = Performance::instance()->config;
        $this->assertTrue($config->isConsoleLive());
    }
}
