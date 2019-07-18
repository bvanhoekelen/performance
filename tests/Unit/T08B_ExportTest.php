<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T08B_ExportTest extends T08A_ExportTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
