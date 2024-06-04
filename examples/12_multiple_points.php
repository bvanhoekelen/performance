<?php

/*
 * Require Performance
 */

require_once(__DIR__.'/../vendor/autoload.php');
use Performance\Performance;

/*
 * Multiple point example
 * Note: Multiple point are less accurate!
 */

// Start multiple point 1
Performance::point('Multiple point 1', true);

Performance::point('Normal point 1');
Performance::finish();
Performance::point('Normal point 2');
Performance::finish();
Performance::point('Normal point 3');

// Start multiple point 2
Performance::point('Multiple point 2', true);
Performance::point('Normal point 4');

// Stop multiple points 1 and normal point 4
Performance::finish('Multiple point 1');

// Finish all tasks and show test results
// Multiple point 2 wil bee automatic finish
Performance::results();