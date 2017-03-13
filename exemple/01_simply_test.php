<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');
use Performance\Performance;

/*
 * One simply performance check
 */

Performance::point();

//
// Run task A
//

// Finish all tasks and show test results
Performance::result();
