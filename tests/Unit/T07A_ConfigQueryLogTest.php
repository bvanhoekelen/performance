<?php namespace Tests\Unit;

use Performance\Performance;
use Performance\Config;


class T07A_ConfigQueryLogTest extends \PHPUnit_Framework_TestCase
{
    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    public function testConfigQueryLog()
    {
        $this->setTestUp();

        // You can specify the characters you want to strip
        Config::setQueryLog(false);
        Config::setQueryLog(true);
        Config::setQueryLog(true, 'resume');
        Config::setQueryLog(true, 'full');
        Config::setQueryLog(false, 'full');

        // Run task A
        $this->taskA();

        // Finish all tasks and show test results
        Performance::results();
    }

    public function testConfigQueryLogIsTrue()
    {
        $configItem = Performance::instance()->config->isQueryLog();
        $this->assertFalse($configItem);
    }

    // Create task

    private function taskA()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        //
        // Run code
        usleep(2000);
        //

        // Finish point Task A
        Performance::finish();
    }
}