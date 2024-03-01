<?php

/*
 * Require Performance
 */
use Performance\Performance;
require_once(__DIR__.'/../vendor/autoload.php');

/*
 * One simply performance check with label
 */

Performance::point('Task A');

// Run task A
for($x = 0; $x < 100; $x++)
{
    echo ".";
}

// Finish all tasks and show test results
Performance::results();

