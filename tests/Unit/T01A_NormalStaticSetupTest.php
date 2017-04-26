<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T01A_NormalStaticSetupTest extends \PHPUnit_Framework_TestCase
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
