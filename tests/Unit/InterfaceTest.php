<?php namespace Tests\Unit;

class InterfaceTest extends \PHPUnit\Framework\TestCase
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
