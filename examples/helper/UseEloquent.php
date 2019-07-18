<?php

////Use laravel Eloquent for database connection
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Events\Dispatcher;

$capsule = new DB();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => '127.0.0.1',
    'port' => '8889',
    'database' => 'performance',
    'username' => 'root',
    'password' => 'root',
]);

// Set the event dispatcher used by Eloquent models... (optional)

$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Bootstrap eloquet
$capsule->bootEloquent();