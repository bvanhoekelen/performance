<?php namespace Performance\Lib;

/**
 * Created by PhpStorm.
 * User: bvanhoekelen
 * Date: 13-03-17
 * Time: 21:35
 */
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
     * @param array|[]   $config
     * @return mixed
     */
    public static function results(array $config = []);


}