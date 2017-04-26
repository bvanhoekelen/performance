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
usleep(7700);

Performance::point();

// Run task A
usleep(3400);

Performance::point();

// Run task A
usleep(270);

// Finish all tasks and show test results
Performance::results();
