<?php namespace Performance;

use Performance\Lib\PerformanceHandler;
use Performance\Lib\PerformanceInterface;

class Performance implements PerformanceInterface
{
    /*
     * Create a performance instance
     */
    private static $performance;

    private static function getPerformance()
    {
        if( ! self::$performance)
            self::$performance = new PerformanceHandler();
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
        $performance = self::getPerformance();
        $performance->point($label);
    }

    /*
     * Finish measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public static function finish($label = null)
    {
        $performance = self::getPerformance();
        $performance->finish($label);
    }

    /*
     * Return test results
     *
     * @param array|[]   $config
     * @return mixed
     */
    public static function results(array $config = [])
    {
        $performance = self::getPerformance();
        $performance->results($config);
    }
}