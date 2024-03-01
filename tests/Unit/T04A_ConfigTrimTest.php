<?php namespace Unit;

use Performance\Performance;
use Performance\Config;
use PHPUnit\Framework\TestCase;

class T04A_ConfigTrimTest extends TestCase
{

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

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

    public function testTrimFunction()
    {
        $points = Performance::instance()->getPoints();

        $this->assertEquals($points[3]->getLabel(), 'TaskA');
        $this->assertEquals($points[4]->getLabel(), 'TaskB');
        $this->assertEquals($points[5]->getLabel(), 'TaskC');
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
}