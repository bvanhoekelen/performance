<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');
use Performance\Performance;
use Performance\Config;

// Bootstrap class
$foo = new Foo();

class Foo
{
    public function __construct()
    {
        // Disable tool manual
        Config::setEnableTool(false);
        // OR use a string
        // Disable tool by the ENV by using the APP_DEBUG value.
//        Config::set(Config::ENABLE_TOOL, 'ENV:APP_DEBUG');

        $this->taskA();
        $this->taskB();

        // Finish all tasks and show test results
        Performance::results();
    }

    public function taskA()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        //
        // Run code
        sleep(.5);
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
        sleep(.5);
        //

        // Finish point Task B
        Performance::finish();
    }
}