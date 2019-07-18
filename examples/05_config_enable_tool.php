<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');

use Performance\Config;
use Performance\Performance;

// Bootstrap class
$foo = new Foo();

class Foo
{
    public function __construct()
    {
        // Disable tool manual
        Config::setEnableTool(false);

        // Or use Laravel ENV
        //Config::setEnableTool('ENV:APP_DEBUG');

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
        usleep(2000);
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
        usleep(2000);
        //

        // Finish point Task B
        Performance::finish();
    }
}