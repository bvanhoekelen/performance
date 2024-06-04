<?php namespace Unit;

use Performance\Performance;
use Performance\Config;
use PHPUnit\Framework\TestCase;

class T05A_ConfigEnableToolTest extends TestCase
{
    protected function setTestUp()
    {
        Performance::instanceReset();
    }

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
}