<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;


class T07A_ConfigQueryLogTest extends \PHPUnit_Framework_TestCase
{
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

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

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

    // Create task

    public function testConfigQueryLogIsTrue()
    {
        $configItem = Performance::instance()->config->isQueryLog();
        $this->assertFalse($configItem);
    }
}