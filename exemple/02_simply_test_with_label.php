<?php

/*
 * Require Performance
 */
require_once('../vendor/autoload.php');
use Performance\Performance;

/*
 * One simply performance check with label
 */

Performance::point('Task A');

//
// Run task A
//

// Finish all tasks and show test results
Performance::result();

