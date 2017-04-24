<?php namespace Tests\Unit;

use Performance\Config;

class ConfigStaticTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
    }

    public function testStaticFunctionPoint()
    {
        Config::setConsoleLive(true);
    }
}
