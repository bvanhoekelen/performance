<?php namespace Performance\Lib;

interface PerformanceInterface
{
    /*
     * Set measuring point X
     *
     * @param string|null   $label
     * @return void
     */
    public static function point($label = null);

    /*
     * Finish measuring point
     *
     * @return void
     */
    public static function finish();

    /*
     * Return test results
     *
     * @return mixed
     */
    public static function results();

}