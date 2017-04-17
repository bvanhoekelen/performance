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
        // You can specify the characters you want to strip
        Config::set(Config::POINT_LABEL_LTRIM, 'synchronize');
        Config::set(Config::POINT_LABEL_RTRIM, 'Run');

        $this->synchronizeTaskARun();
        $this->synchronizeTaskBRun();
        $this->synchronizeTaskCRun();

        // Finish all tasks and show test results
        Performance::results();
    }

    public function synchronizeTaskARun()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        //
        // Run code
        sleep(1);
        //

        // Finish point Task C
        Performance::finish();
    }

    public function synchronizeTaskBRun()
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

    public function synchronizeTaskCRun()
    {
        // Set point Task C
        Performance::point(__FUNCTION__);

        //
        // Run code
        sleep(1);
        //

        // Finish point Task C
        Performance::finish();
    }
}