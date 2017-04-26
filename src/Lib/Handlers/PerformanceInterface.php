<?php namespace Performance\Lib\Handlers;

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
     * Set message
     *
     * @param string|null   $message
     * @param boolean|null   $newLine
     * @return void
     */
    public static function message($message = null, $newLine = true);

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