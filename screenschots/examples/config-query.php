<?php

require_once('../../vendor/autoload.php');
require_once('../../examples/helper/UseEloquent.php');
require_once('../../examples/helper/user.php');

use Performance\Performance;
use Performance\Config;

use Illuminate\Database\Capsule\Manager as DB;

// Bootstrap class
$foo = new Foo();

class Foo
{
    public function __construct()
    {
        // You can specify the characters you want to strip
        Config::setQueryLog(true);
//        Config::setQueryLog(true, 'full');
        Config::setPointLabelNice(true);
        Config::setPointLabelRTrim('Run');

        $this->synchronizeTaskARun();
        $this->synchronizeTaskBRun();
        $this->synchronizeTaskCRun();

        // Finish all tasks and show test results
        Performance::results();
    }

    public function synchronizeTaskARun()
    {
        // Set point Task A
        Performance::point(__FUNCTION__);

        // Create user
        $user = new User();
        $user->name = 'User';
        $user->save();

        // Get users
        $users = User::all();

        // Update user
        $user = User::where('name', 'User')->first();
        $user->email = 'user@user.user';
        $user->save();

        // Delete all
        $users = DB::table('user')->select('*')
            ->where('name', 'User')
            ->delete();

        // Finish point Task A
        Performance::finish();
    }

    public function synchronizeTaskBRun()
    {
        // Set point Task B
        Performance::point(__FUNCTION__);

        //
        // Run code
        //

        // Finish point Task B
        Performance::finish();
    }

    public function synchronizeTaskCRun()
    {
        // Set point Task C
        Performance::point(__FUNCTION__);

        //
        // Run code
        //

        // Finish point Task C
        Performance::finish();
    }
}