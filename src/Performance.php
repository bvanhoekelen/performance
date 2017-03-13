<?php namespace Performance\src;

use Performance\src\lib\PerformanceInterface;

class Performance implements PerformanceInterface
{
    private static $performance;

    private static function getPerformance()
    {
        if( ! self::$performance)
            self::$performance = new Compressor();
        return self::$performance;
    }


    /*
     * Set measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public static function point($label = null)
    {

    }

    /*
     * Finish measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public static function finish($label = null)
    {

    }

    /*
     * Return test results
     *
     * @param array|[]   $config
     * @return mixed
     */
    public static function results(array $config = [])
    {

    }
}