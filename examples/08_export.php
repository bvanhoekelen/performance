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
// Run task A
for($x = 0; $x < 100; $x++)
{
    echo ".";
}

Performance::message('This is a message');

// Finish all tasks and show test results
$export = Performance::results(); // Print and return export handler
$export = Performance::export(); // Only return export handler

// Return all information
print_r($export->get());

// Return all information in Json
print_r($export->toJson());

// Return only config
print_r($export->config()->get());

// Return only points in Json
print_r($export->points()->toJson());

// Return file_put_contents() results
print_r($export->toFile('export.txt'));
