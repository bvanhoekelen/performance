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
    private static $bootstrap = false;

    public static function instance()
    {
        if( ! self::$performance) {
            self::$performance = new PerformanceHandler(new ConfigHandler());
        }
        return self::$performance;
    }

    private static function enableTool()
    {
        $performance = self::instance();

        // Check DISABLE_TOOL
        if( ! $performance->config->isEnableTool())
            return false;

        // Check bootstrap
        if( ! self::$bootstrap)
        {
            $performance->bootstrap();
            self::$bootstrap = true;
        }

        return true;
    }

    /*
     * Set measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public static function point($label = null)
    {
        if( ! self::enableTool() )
            return;

        // Run
        self::$performance->point($label);
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
        if( ! self::enableTool() or ! $message)
            return;

        // Run
        self::$performance->message($message, $newLine);
    }


    /*
     * Finish measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public static function finish()
    {
        if( ! self::enableTool() )
            return;

        // Run
        self::$performance->finish();
    }

    /*
     * Return test results
     *
     * @return mixed
     */
    public static function results()
    {
        if( ! self::enableTool() )
            return;

        // Run
        self::$performance->results();
    }
}