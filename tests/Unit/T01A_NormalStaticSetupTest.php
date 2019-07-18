<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Performance;

class T01A_NormalStaticSetupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @throws \Exception
     */
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

    protected function setTestUp()
    {
        Performance::instanceReset();
    }
}
