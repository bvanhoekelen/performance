<?php namespace Unit;

use Performance\Performance;
use PHPUnit\Framework\TestCase;

class T01A_NormalStaticSetupTest extends TestCase
{
    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    public function testStaticFunctionPoint()
    {
        // Reset
        $this->setTestUp();

        // Test static functions
        Performance::instance();
        Performance::point();
        Performance::point('Label');
        Performance::message('message');
        Performance::finish();
        Performance::results();
        Performance::export();
    }
}
