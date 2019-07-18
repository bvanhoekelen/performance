<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Performance;


class T08A_ExportTest extends \PHPUnit_Framework_TestCase
{
    public function testConfigQueryLog()
    {
        $this->setTestUp();

        // Run task A
        $this->taskA();

        // Finish all and return export class
        $export = Performance::results();

        // Return all information
        print_r($export->get());

        // Return all information in Json
        print_r($export->toJson());

        // Return only config
        print_r($export->config()->get());

        // Return only points in Json
        print_r($export->points()->toJson());

        // Return only points in Json
        print_r($export->toFile('tests/Unit/Fixtures/export.txt'));
    }

    protected function setTestUp()
    {
        Performance::instanceReset();
    }

    private function taskA()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        //
        // Run code
        usleep(2000);
        //

        Performance::message('This is a message');

        // Finish point Task A
        Performance::finish();
    }

    public function testCheckJsonForAll()
    {
        $export = Performance::export();
        $this->assertJson($export->toJson());
    }

    public function testCheckJsonForConfig()
    {
        $export = Performance::export();
        $this->assertJson($export->config()->toJson());
    }

    // Create task

    public function testCheckJsonForPoints()
    {
        $export = Performance::results();
        $this->assertJson($export->points()->toJson());
    }
}