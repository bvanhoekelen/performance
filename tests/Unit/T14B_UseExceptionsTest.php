<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T14B_UseExceptionsTest extends T14A_UseExceptionsTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
