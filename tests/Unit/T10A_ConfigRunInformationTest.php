<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T10A_ConfigRunInformationTest extends \PHPUnit_Framework_TestCase
{

    public function testConfigRunInformation()
    {
        $this->setTestUp();

        // Set config
        Config::setRunInformation(true);

        // Run test tasks
        $this->synchronizeTaskARun();

        // Finish all tasks and show test results
        Performance::results();
    }

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    // Create task

    private function synchronizeTaskARun()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        //
        // Run code
        usleep(2000);
        //

        // Finish point Task C
        Performance::finish();
    }
}