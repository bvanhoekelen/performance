<?php

/*
 * Require Performance
 */

require_once(__DIR__.'/../vendor/autoload.php');
use Performance\Performance;
use Performance\Config;

/*
 * Set config item
 */
Config::setConsoleLive(true);
Config::setRunInformation(true);

/*
 * One simply performance check
 */
Performance::point();

// Run task A
for($x = 0; $x < 100; $x++)
{
    echo ".";
    usleep(3000);
}

// Finish all tasks and show test results
Performance::results();
