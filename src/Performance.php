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
    public static function finish()
    {
        $performance = self::getPerformance();
        $performance->finish();
    }

    /*
     * Return test results
     *
     * @return mixed
     */
    public static function results()
    {
        $performance = self::getPerformance();
        $performance->results();
    }
}