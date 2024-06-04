<?php namespace Unit;

use Performance\Performance;
use Performance\Config;
use PHPUnit\Framework\TestCase;

class T10A_ConfigRunInformationTest extends TestCase
{

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

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