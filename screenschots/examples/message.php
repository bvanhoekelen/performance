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

Performance::message('Add custom message job done!');

Performance::point();

// Run task A
usleep(3400);

Performance::message('Add multiple custom message 1#');
Performance::message('Add multiple custom message 2#');

Performance::point('Start H');

// Run task A
usleep(270);

Performance::message('Add message to label', false);

// Finish all tasks and show test results
Performance::results();
