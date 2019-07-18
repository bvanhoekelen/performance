<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T04A_ConfigTrimTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @throws \Exception
     */
    public function testStaticFunctionPoint()
    {
        $this->setTestUp();

        // You can specify the characters you want to strip
        Config::setPointLabelLTrim('synchronize');
        Config::setPointLabelRTrim('Run');

        // Run test tasks
        $this->synchronizeTaskARun();
        $this->synchronizeTaskBRun();
        $this->synchronizeTaskCRun();

        // Finish all tasks and show test results
        Performance::results();
    }

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    /**
     * @throws \Exception
     */
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


    // Create task

    /**
     * @throws \Exception
     */
    private function synchronizeTaskBRun()
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

    /**
     * @throws \Exception
     */
    private function synchronizeTaskCRun()
    {
        // Set point Task C
        Performance::point(__FUNCTION__);

        //
        // Run code
        usleep(2000);
        //

        // Finish point Task C
        Performance::finish();
    }

    public function testTrimFunction()
    {
        $points = Performance::instance()->getPoints();

        $this->assertEquals($points[ 3 ]->getLabel(), 'TaskA');
        $this->assertEquals($points[ 4 ]->getLabel(), 'TaskB');
        $this->assertEquals($points[ 5 ]->getLabel(), 'TaskC');
    }
}