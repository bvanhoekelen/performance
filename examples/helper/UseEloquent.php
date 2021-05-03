<?php

////Use laravel Eloquent for database connection
use Illuminate\Database\Capsule\Manager as DB;

$capsule = new DB();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'port' => '3306',
    'database' => 'performance',
    'username' => 'root',
    'password' => 'root',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Bootstrap eloquet
$capsule->bootEloquent();
