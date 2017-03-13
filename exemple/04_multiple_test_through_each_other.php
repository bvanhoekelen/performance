<?php

/*
 * Require Performance
 */
require_once('../vendor/autoload.php');
use Performance\Performance;

/*
 * Performing multiple test through each other
 */

Performance::point('TASK A');
Performance::point('TASK B');
// RUN TASK A
// RUN TASK B

Performance::finish('TASK A');
// RUN TASK B

Performance::point('TASK C');

// RUN TASK B

Performance::finish();

// Show test results
Performance::results();

// Options
