<?php

/*
 * Require Performance
 */

require_once('../vendor/autoload.php');
require_once('helper/UseEloquent.php');

use Illuminate\Database\Capsule\Manager as DB;

use Performance\Performance;
use Performance\Config;

// Bootstrap class
$foo = new Foo();

class Foo
{
    public function __construct()
    {
        // Enable query log
        Config::set(Config::QUERY_LOG, true);

        $this->selectQuery();
        $this->taskB();


//        dd(DB::getQueryLog());

        // Finish all tasks and show test results
        Performance::results();
    }

    public function selectQuery()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        $users = DB::table('user')->select('*')
            ->where('id', '<=', '1077')
            ->get();

//        $user = DB::table('user')->select('*')
//            ->where('name', 'Bart')
//            ->first();

//        $user->email = 'bart@gmail.com';
//
//        $user->save();

//        $users = DB::table('user')->select('*')
//            ->where('id', '<=', '1072')
//            ->delete();

        foreach($users as $user)
        {
            echo $user->name . PHP_EOL;
        }

        // Finish point Task A
        Performance::finish();
    }

    public function taskB()
    {
        // Set point Task B
        Performance::point(__FUNCTION__);

        //
        // Run code
        //

        // Finish point Task B
        Performance::finish();
    }
}