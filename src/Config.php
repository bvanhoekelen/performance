<?php namespace Performance;

use Performance\Lib\ConfigHandler;
use Performance\Lib\ConfigInterface;

class Config implements ConfigInterface
{
    CONST CONSOLE_LIVE = 'consoleLive';                 // Determined if the console results are live or not
    CONST POINT_LABEL_LTRIM = 'pointLabelLtrim';        // Call ltrim function on label
    CONST POINT_LABEL_RTRIM = 'pointLabelRtrim';        // Call rtrim function on label
    CONST ENABLE_TOOL = 'enableTool';                 // Disable tool for production

    /*
     * Create a config instance
     */
    private static $config;

    private static function getConfig()
    {
        if (!self::$config)
            self::$config = new ConfigHandler();
        return self::$config;
    }

    /*
     * Change config item
     *
     * @param string    $item
     * @param mixed     $value
     */
    public static function set($item, $value)
    {
        $config = self::getConfig();
        $config->set($item, $value);
    }

    /*
     * Get config item
     *
     * @param string    $item
     * @return mixed
     */
    public static function get($item, $default = null)
    {
        $config = self::getConfig();
        return $config->get($item, $default);
    }

    /*
     * Reset config
     */
    public static function reset()
    {
        $config = self::getConfig();
        return $config->reset();
    }
}