<?php namespace Tests\Unit;

use Performance\Performance;
use Performance\Config;

class ConfigEnableToolTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
    }

    public function testStaticFunctionPoint()
    {
        // You can specify the characters you want to strip
        Config::setEnableTool(false);

        $this->taskA();
        $this->taskB();

        // Finish all tasks and show test results
        Performance::results();
    }

    // Create task

    public function taskA()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        //
        // Run code
        sleep(1);
        //

        // Finish point Task A
        Performance::finish();
    }

    public function taskB()
    {
        // Set point Task B
        Performance::point(__FUNCTION__);

        //
        // Run code
        sleep(1);
        //

        // Finish point Task B
        Performance::finish();
    }
}