<?php

/*
 * Require Performance
 */
require_once('../vendor/autoload.php');
use Performance\Performance;

/*
 * Performing multiple performance test
 */
Performance::point();
// RUN TASK A

Performance::point(); // -> Finish task A and start new point for task B
// RUN TASK B

// Finish all tasks and show test results
Performance::results();