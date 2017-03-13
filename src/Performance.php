<?php namespace Performance;

use Performance\Lib\PerformanceInterface;

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
        echo "Ja";

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