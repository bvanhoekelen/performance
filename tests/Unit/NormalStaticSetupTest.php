<?php namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class NormalStaticSetupTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
    }

    public function testStaticFunctionPoint()
    {
        Performance::point();
        Performance::point();
    }

    public function testStaticFunctionPointWithLabel()
    {
        Performance::point('Label');
    }

    public function testStaticFunctionFinish()
    {
        Performance::finish();
    }

    public function testStaticFunctionResult()
    {
        Performance::results();
    }

}
