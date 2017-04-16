<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');
use Performance\Performance;
use Performance\Config;

/*
 * Set config item
 */
Config::set(Config::CONSOLE_LIVE, true);

/*
 * One simply performance check
 */
Performance::point();

// Run task A
for($x = 0; $x < 100; $x++)
{
    echo ".";
}

// Finish all tasks and show test results
Performance::results();
