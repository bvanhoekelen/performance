<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');

use Performance\Config;
use Performance\Performance;


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
