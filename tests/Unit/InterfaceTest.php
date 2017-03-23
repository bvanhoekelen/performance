<?php namespace Tests\Unit;

class InterfaceTest extends \PHPUnit_Framework_TestCase
{
    protected $stack;

    protected function setUp()
    {
        $this->stack = [];
    }

    public function testOne()
    {
        $this->assertEquals( 0, count($this->stack));
    }

}
