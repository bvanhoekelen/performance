<?php namespace Performance\Lib;

interface ConfigInterface
{
    /*
     * Set config item console live
     * @param bool $status
     */
    public static function setConsoleLive($status);

    /*
     * Set config item point label RTrim
     * @param bool $mask
     */
    public static function setPointLabelLTrim($mask);

    /*
     * Set config item point label RTrim
     * @param bool $mask
     */
    public static function setPointLabelRTrim($mask);

    /*
     * Set config item enable tool
     * @param bool $value
     */
    public static function setEnableTool($value);

    /*
     * Set config item enable tool
     * @param bool $status
     */
    public static function setQueryLog($status);
}