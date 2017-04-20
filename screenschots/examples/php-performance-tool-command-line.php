<?php

/*
 * Require Performance
 */

require_once('../../vendor/autoload.php');
use Performance\Performance;

Performance::point();

$a = [];
for($x = 0; $x < 1000; $x++)
{
    $a[] = md5($x);
}

Performance::point();
$a = [];
for($x = 0; $x < 10100; $x++)
{
    $a[] = md5($x);
}

Performance::point();
$a = [];
for($x = 0; $x < 102100; $x++)
{
    $a[] = md5($x);
}

Performance::point();
$a = [];
for($x = 0; $x < 10400; $x++)
{
    $a[] = md5($x);
}

Performance::point();
$a = [];
for($x = 0; $x < 5000; $x++)
{
    $a[] = md5($x);
}

Performance::point();
$a = [];
for($x = 0; $x < 545000; $x++)
{
    $s = $x * 723 / 7239;
    $a[] = md5($s);
}

Performance::point();
$a = [];
for($x = 0; $x < 10400; $x++)
{
    $a[] = md5($x);
}

// Finish all tasks and show test results
Performance::results();
