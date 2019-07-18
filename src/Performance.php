<?php

declare(strict_types=1);

namespace Performance;

use Exception;
use Performance\Lib\Handlers\PerformanceHandler;

/**
 * Class Performance
 * @package Performance
 */
class Performance
{
    /**
     * Create a performance instance
     *
     * @var PerformanceHandler
     */
    protected static $performance;

    /**
     * @var bool
     */
    protected static $bootstrap = false;

    /**
     * Set measuring point X
     *
     * @param string|null $label
     * @param bool $isMultiplePoint
     * @return void
     * @throws Exception
     */
    public static function point($label = null, $isMultiplePoint = false)
    {
        if (!static::enableTool()) {
            return;
        }

        // Run
        static::$performance->point($label, $isMultiplePoint);
    }

    /**
     * @return bool
     * @throws Exception
     */
    protected static function enableTool()
    {
        $performance = static::instance();

        // Check DISABLE_TOOL
        if (!$performance->config->isEnableTool()) {
            return false;
        }

        // Check bootstrap
        if (!static::$bootstrap) {
            $performance->bootstrap();
            static::$bootstrap = true;
        }

        return true;
    }

    /**
     * @return PerformanceHandler
     */
    public static function instance()
    {
        if (!static::$performance) {
            static::$performance = new PerformanceHandler();
        }

        return static::$performance;
    }

    /**
     * Set a message associated with the point
     *
     * @param string|null $message
     * @param boolean|null $newLine
     * @return void
     *
     * @throws Exception
     */
    public static function message($message = null, $newLine = true)
    {
        if (!static::enableTool() || !$message) {
            return;
        }

        // Run
        static::$performance->message($message, $newLine);
    }


    /**
     * Finish measuring point X
     *
     * @param string|null $multiplePointLabel
     * @return void
     * @throws Exception
     */
    public static function finish($multiplePointLabel = null)
    {
        if (!static::enableTool()) {
            return;
        }

        // Run
        static::$performance->finish($multiplePointLabel);
    }

    /**
     * Export helper
     *
     * @return Lib\Handlers\ExportHandler|void
     * @throws Exception
     */
    public static function export()
    {
        if (!static::enableTool()) {
            return;
        }

        // Run
        return static::$performance->export();
    }

    /**
     * Return test results
     *
     * @return Lib\Handlers\ExportHandler|void
     * @throws Exception
     */
    public static function results()
    {
        if (!static::enableTool()) {
            return;
        }

        // Run
        return static::$performance->results();
    }

    /**
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
