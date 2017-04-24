<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T01A_NormalStaticSetupTest extends \PHPUnit_Framework_TestCase
{
    public function testStaticFunctionPoint()
    {
        // Reset
        Performance::instanceReset();

        // Test static functions
        Performance::instance();
        Performance::point();
        Performance::point('Label');
        Performance::message('message');
        Performance::finish();
        Performance::results();
    }
}
