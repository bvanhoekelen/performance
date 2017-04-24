<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T06A_PerformanceMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testStaticFunctionPoint()
    {
        // Reset
        Performance::instanceReset();

        // Test static functions
        Performance::point('Label');
        Performance::message('add to', false);
        Performance::message(' label', false);
        Performance::message('New line #1', true);
        Performance::message('New line #2');
        Performance::finish();
        Performance::message('skip');
        Performance::message('skip', false);
        Performance::results();
    }

    public function testMessageAddToLabel()
    {
        $points = Performance::instance()->getPoints();
        $point = $points[2];

        $this->assertEquals('Label - add to label', $point->getLabel());
    }

    public function testMessageAddToNewLine()
    {
        $points = Performance::instance()->getPoints();
        $lines = $points[2]->getNewLineMessage();

        $this->assertEquals('New line #1', $lines[0]);
        $this->assertEquals('New line #2', $lines[1]);
    }
}
