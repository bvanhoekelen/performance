<?php

/*
 * Require Performance
 */

require_once(__DIR__.'/../vendor/autoload.php');
use Performance\Performance;
use Performance\Config;


Config::setClearScreen(false);

/*
 * Prevent clear screen example
 */

// Test A
Performance::point('A');

try {
	Performance::point('A');
} catch (Exception $e) {
	print_r($e);
}


Performance::results();
