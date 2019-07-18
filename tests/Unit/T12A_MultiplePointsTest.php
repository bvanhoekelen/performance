<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Performance;

class T12A_MultiplePointsTest extends \PHPUnit_Framework_TestCase
{

    public function testConfigRunInformation()
    {
        $this->setTestUp();

        // Start multiple point 1
        Performance::point('Multiple point 1', true);


        Performance::point('Normal point 1');
        Performance::finish();
        Performance::point('Normal point 2');
        Performance::finish();
        Performance::point('Normal point 3');

        // Start multiple point 2
        Performance::point('Multiple point 2', true);
        Performance::point('Normal point 4');

        // Stop multiple points 1 and normal point 4
        Performance::finish('Multiple point 1');


        // Finish all tasks and show test results
        // Multiple point 2 wil bee automatic finish
        Performance::results();
    }

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    public function testPointLabelNiceFunction()
    {

        $export = Performance::export();
        $points = $export->points()->get();

        // Check label
        $this->assertEquals($points[ 0 ]->getLabel(), '__POINT_PRELOAD');
        $this->assertEquals($points[ 1 ]->getLabel(), '__MULTIPLE_POINT_PRELOAD');
        $this->assertEquals($points[ 2 ]->getLabel(), 'Calibrate point');
        $this->assertEquals($points[ 2 ]->getNewLineMessage()[ 0 ], 'Start multiple point Multiple point 1');
        $this->assertEquals($points[ 3 ]->getLabel(), 'Normal point 1');
        $this->assertEquals($points[ 4 ]->getLabel(), 'Normal point 2');
        $this->assertEquals($points[ 5 ]->getLabel(), 'Normal point 3');
        $this->assertEquals($points[ 5 ]->getNewLineMessage()[ 0 ], 'Start multiple point Multiple point 2');
        $this->assertEquals($points[ 6 ]->getLabel(), 'Normal point 4');
        $this->assertEquals($points[ 7 ]->getLabel(), 'Multiple point 1');
        $this->assertEquals($points[ 8 ]->getLabel(), 'Multiple point 2');

        // Check point is multiple point
        $this->assertTrue($points[ 1 ]->isMultiplePoint());
        $this->assertTrue($points[ 7 ]->isMultiplePoint());
        $this->assertTrue($points[ 8 ]->isMultiplePoint());

        // Check point is not multiple point
        $this->assertFalse($points[ 0 ]->isMultiplePoint());
        $this->assertFalse($points[ 2 ]->isMultiplePoint());
        $this->assertFalse($points[ 3 ]->isMultiplePoint());
        $this->assertFalse($points[ 4 ]->isMultiplePoint());
        $this->assertFalse($points[ 5 ]->isMultiplePoint());
        $this->assertFalse($points[ 6 ]->isMultiplePoint());
    }
}