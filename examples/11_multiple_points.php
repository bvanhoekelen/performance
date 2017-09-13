<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');
use Performance\Performance;

/*
 * One simply performance check
 */
Performance::point('1A');
Performance::point('1B');
Performance::point('1C');
Performance::point('1D');

Performance::point('2A');
Performance::finish();
Performance::point('2B');
Performance::finish();
Performance::point('2C');
Performance::finish();
Performance::point('2D');
Performance::finish();


// Finish all tasks and show test results
Performance::results();
