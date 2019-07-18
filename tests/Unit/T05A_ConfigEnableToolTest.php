<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T05A_ConfigEnableToolTest extends \PHPUnit_Framework_TestCase
{
    public function testStaticFunctionPoint()
    {
        // Reset
        $this->setTestUp();

        // You can specify the characters you want to strip
        Config::setEnableTool(false);

        $this->taskA();
        $this->taskB();

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

    private function taskB()
    {
        // Set point Task B
        Performance::point(__FUNCTION__);

        //
        // Run code
        usleep(2000);
        //

        // Finish point Task B
        Performance::finish();
    }

    // Create task

    public function testSkipTool()
    {
        $points = Performance::instance()->getPoints();
        $this->assertEquals(0, count($points));
    }

    public function testConfigEnableToolIsFalse()
    {
        $configItem = Performance::instance()->config->isEnableTool();
        $this->assertFalse($configItem);
    }
}