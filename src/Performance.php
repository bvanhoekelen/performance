<?php namespace Performance;

use Performance\Lib\ConfigHandler;
use Performance\Lib\PerformanceHandler;
use Performance\Lib\PerformanceInterface;

class Performance implements PerformanceInterface
{
    /*
     * Create a performance instance
     */
    private static $performance;

    public static function instance()
    {
        if( ! self::$performance)
            self::$performance = new PerformanceHandler( new ConfigHandler() );
        return self::$performance;
    }

    /*
     * Set measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public static function point($label = null)
    {
        // Check DISABLE_TOOL
        if( ! Config::get(Config::ENABLE_TOOL))
            return;

        // Run
        $performance = self::instance();
        $performance->point($label);
    }

    /*
     * Set message
     *
     * @param string|null   $message
     * @param boolean|null   $newLine
     * @return void
     */
    public static function message($message = null, $newLine = true)
    {
        // Check DISABLE_TOOL
        if( ! Config::get(Config::ENABLE_TOOL) or ! $message)
            return;

        $performance = self::instance();
        $performance->message($message, $newLine);
    }


    /*
     * Finish measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public static function finish()
    {
        // Check DISABLE_TOOL
        if( ! Config::get(Config::ENABLE_TOOL))
            return;

        $performance = self::instance();
        $performance->finish();
    }

    /*
     * Return test results
     *
     * @return mixed
     */
    public static function results()
    {
        // Check DISABLE_TOOL
        if( ! Config::get(Config::ENABLE_TOOL))
            return;

        $performance = self::instance();
        $performance->results();
    }
}