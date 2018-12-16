<?php namespace Performance;

class Config
{
    /*
     * Create a config instance
     */
    protected static $config;

    protected static function instance()
    {
        if (!static::$config)
            static::$config = Performance::instance()->config;
        return static::$config;
    }

    protected static function enableTool()
    {
        $config = static::instance();

        // Check DISABLE_TOOL
        if( ! $config->isEnableTool())
            return false;

        return true;
    }

    /*
     * Set config item console live
     * @param bool $status
     * return void
     */
    public static function setConsoleLive($status)
    {
        if( ! static::enableTool())
            return;

        static::$config->setConsoleLive($status);
    }

    /*
     * Set config item point label LTrim
     * @param bool $mask
     * return void
     */
    public static function setPointLabelLTrim($mask)
    {
        if( ! static::enableTool())
            return;

        static::$config->setPointLabelLTrim($mask);
    }

    /*
     * Set config item point label RTrim
     * @param bool $mask
     * return void
     */
    public static function setPointLabelRTrim($mask)
    {
        if( ! static::enableTool())
            return;

        static::$config->setPointLabelRTrim($mask);
    }

    /*
     * Set config item point label RTrim
     * @param mixed $value
     * return void
     */
    public static function setEnableTool($value)
    {
        if( ! static::enableTool())
            return;

        static::$config->setEnableTool($value);
    }

    /*
     * Set config item query log
     * @param mixed $value
     * @param string $viewType
     * return void
     */
    public static function setQueryLog($status, $viewType = null)
    {
        if( ! static::enableTool())
            return;

        static::$config->setQueryLog($status, $viewType);
    }

    /*
     * Set config item presenter
     * @param mixed $value
     * return void
     */
    public static function setPresenter($type)
    {
        if( ! static::enableTool())
            return;

        static::$config->setPresenter($type);
    }

    /*
     * Set config point label nice
     * @param bool $status
     * return void
     */
    public static function setPointLabelNice($status)
    {
        if( ! static::enableTool())
            return;

        static::$config->setPointLabelNice($status);
    }

    /*
     * Set config point label nice
     * @param bool $status
     * return void
     */
    public static function setRunInformation($status)
    {
        if( ! static::enableTool())
            return;

        static::$config->setRunInformation($status);
    }

	/*
	 * Set config point label nice
	 * @param bool $status
	 * return void
	 */
	public static function setClearScreen($status)
	{
		if( ! static::enableTool())
			return;

		static::$config->setClearScreen($status);
	}

    /*
     * Reset
     */
    public static function instanceReset()
    {
        static::$config = null;
    }
}
