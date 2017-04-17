<?php namespace Tests\Unit;

use Performance\Performance;
use Performance\Config;

class ConfigDisableToolTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        Config::reset();
    }

    public function testStaticFunctionPoint()
    {
        // You can specify the characters you want to strip
        Config::set(Config::DISABLE_TOOL, true);

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