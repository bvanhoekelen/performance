<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');
use Performance\Performance;

/*
 * One simply performance check
 */

//
Performance::point('Multiple point 1', true);

Performance::point('Normal point 1');
Performance::finish();
Performance::point('Normal point 2');
Performance::finish();
Performance::point('Normal point 3');
Performance::point('Multiple point 2', true);
Performance::point('Normal point 4');

Performance::finish('Multiple point 1');
Performance::finish('Multiple point 2');


// Finish all tasks and show test results
Performance::results();

$export = Performance::export();

//dd($export);
