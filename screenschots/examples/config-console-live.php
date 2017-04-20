<?php

/*
 * Require Performance
 */

require_once('../../vendor/autoload.php');
use Performance\Performance;

/*
 * One simply performance check
 */
Performance::point();

// Run task A
for($x = 0; $x < 100; $x++)
{
//    echo ".";
}

// Finish all tasks and show test results
Performance::results();
