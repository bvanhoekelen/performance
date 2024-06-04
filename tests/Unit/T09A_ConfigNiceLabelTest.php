<?php namespace Unit;

use Performance\Performance;
use Performance\Config;
use PHPUnit\Framework\TestCase;

class T09A_ConfigNiceLabelTest extends TestCase
{

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    public function testConfigNiceLabel()
    {
        $this->setTestUp();

        // You can specify the characters you want to strip
        Config::setPointLabelNice(true);

        // Run test tasks
        $this->synchronizeTaskARun();
        $this->synchronizeTaskBRun();
        $this->synchronizeTaskCRun();
        Performance::point('pointWitText - And - aaa');

        // Finish all tasks and show test results
        Performance::results();
    }

    public function testPointLabelNiceFunction()
    {
        $points = Performance::instance()->getPoints();

        $this->assertEquals($points[3]->getLabel(), 'Synchronize Task A Run');
        $this->assertEquals($points[4]->getLabel(), 'Synchronize Task B Run');
        $this->assertEquals($points[5]->getLabel(), 'Synchronize Task C Run');
        $this->assertEquals($points[6]->getLabel(), 'Point Wit Text - And - aaa');
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