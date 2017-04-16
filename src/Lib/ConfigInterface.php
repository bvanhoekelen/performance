<?php namespace Performance\Lib;

interface ConfigInterface
{
    /*
     * Change config item
     *
     * @param string    $item
     * @param mixed     $value
     */
    public static function set($item, $value);

    /*
     * Get config item
     *
     * @param string    $item
     * @param mixed     $default
     * @return mixed
     */
    public static function get($item, $default = null);

    /*
     * Reset config
     */
    public static function reset();
}