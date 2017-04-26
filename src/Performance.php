<?php namespace Performance;

use Performance\Lib\Handlers\PerformanceHandler;

class Performance
{
    /*
     * Create a performance instance
     */
    private static $performance;
    private static $bootstrap = false;

    public static function instance()
    {
        if( ! self::$performance)
            self::$performance = new PerformanceHandler();
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
     * Set a message associated with the point
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
     * Export helper
     *
     * @return Performance\Lib\Handlers\ExportHandler
     */
    public static function export()
    {
        if( ! self::enableTool() )
            return;

        // Run
        return self::$performance->export();
    }

    /*
     * Return test results
     *
     * @return Performance\Lib\Handlers\ExportHandler
     */
    public static function results()
    {
        if( ! self::enableTool() )
            return;

        // Run
        return self::$performance->results();
    }

    /*
     * Reset
     */
    public static function instanceReset()
    {
        // Run
        Config::instanceReset();
        self::$performance = null;
        self::$bootstrap = false;

    }
}