<?php namespace Tests\Unit;

use Performance\Performance;

class NormalStaticSetupTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {

    }

    public function testStaticFunctionPoint()
    {
        Performance::point();
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
