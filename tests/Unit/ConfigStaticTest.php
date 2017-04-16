<?php namespace Tests\Unit;

use Performance\Config;

class ConfigStaticTest extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        Config::reset();
    }

    public function testStaticFunctionPoint()
    {
        Config::set(Config::CONSOLE_LIVE, true);
    }
}
