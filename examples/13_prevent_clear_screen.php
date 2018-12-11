<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');
use Performance\Performance;
use Performance\Config;

Config::setClearScreen(false);

/*
 * Prevent clear screen example
 */

// Test A
Performance::point('A');
Performance::results();

// Performance::instanceReset();
// Config::setClearScreen(false); // Config is also reset!
//
// Test B
// Performance::point('B');
// Performance::results();
