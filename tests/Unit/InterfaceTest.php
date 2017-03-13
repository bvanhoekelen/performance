<?php namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class InterfaceTest extends TestCase
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
