<?php namespace Performance;

use Performance\Lib\ConfigInterface;

class Config implements ConfigInterface
{
    /*
     * Create a config instance
     */
    private static $config;

    private static function instance()
    {
        if (!self::$config)
            self::$config = Performance::instance()->config;
        return self::$config;
    }

    private static function enableTool()
    {
        $config = self::instance();

        // Check DISABLE_TOOL
        if( ! $config->isEnableTool())
            return false;

        return true;
    }

    /*
     * Set config item console live
     * @param bool $status
     */
    public static function setConsoleLive($status)
    {
        if( ! self::enableTool())
            return;

        self::$config->setConsoleLive($status);
    }

    /*
     * Set config item console live
     * @param bool $status
     */
    public static function setPoint($status)
    {
        if( ! self::enableTool())
            return;

        self::$config->setConsoleLive($status);
    }

    /*
     * Set config item point label LTrim
     * @param bool $mask
     */
    public static function setPointLabelLTrim($mask)
    {
        if( ! self::enableTool())
            return;

        self::$config->setPointLabelLTrim($mask);
    }

    /*
     * Set config item point label RTrim
     * @param bool $mask
     */
    public static function setPointLabelRTrim($mask)
    {
        if( ! self::enableTool())
            return;

        self::$config->setPointLabelRTrim($mask);
    }

    /*
     * Set config item point label RTrim
     * @param mixed $value
     */
    public static function setEnableTool($value)
    {
        if( ! self::enableTool())
            return;

        self::$config->setEnableTool($value);
    }

    /*
     * Set config item query log
     * @param mixed $value
     */
    public static function setQueryLog($status)
    {
        if( ! self::enableTool())
            return;

        self::$config->setQueryLog($status);
    }

    /*
     * Reset
     */
    public static function instanceReset()
    {
        self::$config = null;
    }


}