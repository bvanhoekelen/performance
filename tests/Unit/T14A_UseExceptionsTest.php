<?php namespace Unit;

use Performance\Performance;
use PHPUnit\Framework\TestCase;

class T14A_UseExceptionsTest extends TestCase
{
    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    public function testPointInvalidArgumentException()
    {
        $this->setTestUp();

        // Start multiple point 1
        Performance::point('A');
        $this->expectException(\InvalidArgumentException::class);
        Performance::point('A');

        Performance::results();
    }
}
