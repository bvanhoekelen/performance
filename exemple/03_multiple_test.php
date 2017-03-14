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
// Run task A
$y = [];
for($x = 0; $x < 200000; $x++)
{
    $y[] = $x * 2 * 7;
    $y[] = $x * 2 * 7;
    echo ".";
}

echo "3";

Performance::point(); // -> Finish task A and start new point for task B
// Run task B
for($x = 0; $x < 200000; $x++)
{
    $y[] = $x * 2;
    echo ".";
}


// Finish all tasks and show test results
Performance::results();