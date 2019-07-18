<?php

declare(strict_types=1);

namespace Tests\Unit;

use Performance\Config;
use Performance\Performance;

class T13B_PreventClearScreenTest extends T13A_PreventClearScreenTest
{
    protected function setTestUp()
    {
        Performance::instanceReset();
        Config::setPresenter('web');
    }
}
