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
        if( ! static::$performance)
            static::$performance = new PerformanceHandler();
        return static::$performance;
    }

    private static function enableTool()
    {
        $performance = static::instance();

        // Check DISABLE_TOOL
        if( ! $performance->config->isEnableTool())
            return false;

        // Check bootstrap
        if( ! static::$bootstrap)
        {
            $performance->bootstrap();
            static::$bootstrap = true;
        }

        return true;
    }

    /*
     * Set measuring point X
     *
     * @param string|null   $label
     * @param string|null   $isMultiplePoint
     * @return void
     */
    public static function point($label = null, $isMultiplePoint = false)
    {
        if( ! static::enableTool() )
            return;

        // Run
        static::$performance->point($label, $isMultiplePoint);
    }

    /*
     * Set a message associated with the point
     *
     * @param string|null   $message
     * @param boolean|null  $newLine
     * @return void
     */
    public static function message($message = null, $newLine = true)
    {
        if( ! static::enableTool() or ! $message)
            return;

        // Run
        static::$performance->message($message, $newLine);
    }


    /*
     * Finish measuring point X
     *
     * @param string|null   $multiplePointLabel
     * @return void
     */
    public static function finish($multiplePointLabel = null)
    {
        if( ! static::enableTool() )
            return;

        // Run
        static::$performance->finish($multiplePointLabel);
    }

    /*
     * Export helper
     *
     * @return Performance\Lib\Handlers\ExportHandler
     */
    public static function export()
    {
        if( ! static::enableTool() )
            return;

        // Run
        return static::$performance->export();
    }

    /*
     * Return test results
     *
     * @return Performance\Lib\Handlers\ExportHandler
     */
    public static function results()
    {
        if( ! static::enableTool() )
            return;

        // Run
        return static::$performance->results();
    }

    /*
     * Reset
     */
    public static function instanceReset()
    {
        // Run
        Config::instanceReset();
        static::$performance = null;
        static::$bootstrap = false;

    }
}
