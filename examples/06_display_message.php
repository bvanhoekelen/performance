<?php

/*
 * Require Performance
 */

require_once(__DIR__.'/../vendor/autoload.php');
use Performance\Performance;

/*
 * One simply performance check
 */

Performance::point();


Performance::point('Na mij');

// Run task A
for($x = 0; $x < 100; $x++)
{
    echo ".";
}

//Performance::finish();
Performance::message('This is a message');
Performance::message('In text', false);


Performance::point();

Performance::point();

// Finish all tasks and show test results
Performance::results();
