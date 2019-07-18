<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Performance;

class T06A_PerformanceMessageTest extends \PHPUnit_Framework_TestCase
{
    public function testStaticFunctionPoint()
    {
        // Reset
        $this->setTestUp();

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

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    public function testMessageAddToLabel()
    {
        $points = Performance::instance()->getPoints();
        $point = $points[ 3 ];

        $this->assertEquals('Label - add to label', $point->getLabel());
    }

    public function testMessageAddToNewLine()
    {
        $points = Performance::instance()->getPoints();
        $lines = $points[ 3 ]->getNewLineMessage();

        $this->assertEquals('New line #1', $lines[ 0 ]);
        $this->assertEquals('New line #2', $lines[ 1 ]);
    }
}
