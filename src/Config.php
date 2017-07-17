<?php namespace Performance;

class Config
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
     * return void
     */
    public static function setConsoleLive($status)
    {
        if( ! self::enableTool())
            return;

        self::$config->setConsoleLive($status);
    }

    /*
     * Set config item point label LTrim
     * @param bool $mask
     * return void
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
     * return void
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
     * return void
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
     * @param string $viewType
     * return void
     */
    public static function setQueryLog($status, $viewType = null)
    {
        if( ! self::enableTool())
            return;

        self::$config->setQueryLog($status, $viewType);
    }

    /*
     * Set config item presenter
     * @param mixed $value
     * return void
     */
    public static function setPresenter($type)
    {
        if( ! self::enableTool())
            return;

        self::$config->setPresenter($type);
    }

    /*
     * Set config point label nice
     * @param bool $status
     * return void
     */
    public static function setPointLabelNice($status)
    {
        if( ! self::enableTool())
            return;

        self::$config->setPointLabelNice($status);
    }

    /*
     * Set config point label nice
     * @param bool $status
     * return void
     */
    public static function setRunInformation($status)
    {
        if( ! self::enableTool())
            return;

        self::$config->setRunInformation($status);
    }

    /*
     * Reset
     */
    public static function instanceReset()
    {
        self::$config = null;
    }
}