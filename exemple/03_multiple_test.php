<?php

/*
 * Require Performance
 */
require_once('../vendor/autoload.php');
use Performance\Performance;

echo "Run";

/*
 * Performing multiple performance test
 */
Performance::point('0');
Performance::point();
Performance::point();
Performance::point();
Performance::point();
Performance::point();
Performance::point('A');
Performance::point('B');
// Run task A
$y = [];
for($x = 0; $x < 200000; $x++)
{
    $y[] = $x * 2;
}
Performance::point('C'); // -> Finish task A and start new point for task B
// Run task B
for($x = 0; $x < 200000; $x++)
{
    $y[] = $x * 2;
}


// Finish all tasks and show test results
Performance::results();