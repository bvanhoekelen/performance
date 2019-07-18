<?php

declare(strict_types=1);

namespace Performance;

use Performance\Lib\Handlers\ConfigHandler;
use Performance\Lib\Handlers\PerformanceHandler;

class Config
{
    /**
     * @var Config|PerformanceHandler
     */
    protected static $config;

    /**
     * Set config item console live
     *
     * @param bool $status
     * return void
     */
    public static function setConsoleLive($status)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setConsoleLive($status);
    }

    protected static function enableTool()
    {
        /** @var ConfigHandler $config */
        $config = static::instance();

        // Check DISABLE_TOOL
        if (!$config->isEnableTool()) {
            return false;
        }

        return true;
    }

    /**
     * @return PerformanceHandler
     */
    protected static function instance()
    {
        if (!static::$config) {
            static::$config = Performance::instance()->config;
        }

        return static::$config;
    }

    /**
     * Set config item point label LTrim
     * @param bool $mask
     * return void
     */
    public static function setPointLabelLTrim($mask)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setPointLabelLTrim($mask);
    }

    /**
     * Set config item point label RTrim
     * @param bool $mask
     * return void
     */
    public static function setPointLabelRTrim($mask)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setPointLabelRTrim($mask);
    }

    /**
     * Set config item point label RTrim
     * @param mixed $value
     * return void
     */
    public static function setEnableTool($value)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setEnableTool($value);
    }

    /**
     * Set config item query log
     * @param bool $status
     * @param string $viewType
     * return void
     */
    public static function setQueryLog(bool $status, $viewType = null)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setQueryLog($status, $viewType);
    }

    /**
     * Set config item presenter
     * @param string $type
     */
    public static function setPresenter(string $type)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setPresenter($type);
    }

    /**
     * Set config point label nice
     * @param bool $status
     * return void
     */
    public static function setPointLabelNice($status)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setPointLabelNice($status);
    }

    /**
     * Set config point label nice
     * @param bool $status
     * return void
     */
    public static function setRunInformation($status)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setRunInformation($status);
    }

    /**
     * Set config point label nice
     * @param bool $status
     * return void
     */
    public static function setClearScreen($status)
    {
        if (!static::enableTool()) {
            return;
        }

        static::$config->setClearScreen($status);
    }

    /**
     * Reset
     */
    public static function instanceReset()
    {
        static::$config = null;
    }
}
