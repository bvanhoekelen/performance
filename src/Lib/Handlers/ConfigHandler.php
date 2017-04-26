<?php namespace Performance\Lib\Handlers;

use Performance\Lib\Presenters\Presenter;

class ConfigHandler
{
    // Config items
    private $consoleLive = false;
    private $enableTool = true;
    private $queryLog = false;
    private $pointLabelLTrim = false;
    private $pointLabelRTrim = false;
    private $presenterType;

    /*
     * Hold state of the query log
     * null = not set
     * false = config is false
     * true = query log is set
     */
    public $queryLogState = null;


    public function __construct()
    {
        // Set default
        $this->setDefaultTimeZone();
        $this->setDefaultConsoleLive();
        $this->setDefaultPresenterType();
    }

    public function getAllItemNames()
    {
        return array_keys($this->configItems);
    }

    private function setDefaultTimeZone()
    {
        // Check date function
        if( ! ini_get('date.timezone') )
            date_default_timezone_set('UTC');
    }

    private function setDefaultConsoleLive()
    {
        $shortopts = 'l::';
        $longopts = ['live'];
        $options = getopt($shortopts, $longopts);

        // Set live option
        if(isset($options['l']) or isset($options['live']))
            $this->consoleLiveState = true;
    }

    // Print format
    private function setDefaultPresenterType()
    {
        if (php_sapi_name() == "cli")
            $this->setPresenterType(Presenter::PRESENTER_COMMAND_LINE);
        else
            $this->setPresenterType(Presenter::PRESENTER_WEB);
    }

    // Getters and setters

    /**
     * @return bool
     */
    public function isConsoleLive()
    {
        return $this->consoleLive;
    }

    /**
     * @param bool $consoleLive
     */
    public function setConsoleLive($status)
    {
        $this->consoleLive = $status;
    }

    /**
     * @return bool
     */
    public function isEnableTool()
    {
        return $this->enableTool;
    }

    /**
     * @param bool $enableTool
     */
    public function setEnableTool($value)
    {
        if(is_bool($value))
            $this->enableTool = $value;
        elseif(is_string($value))
        {
            $split = explode(':', $value);

            // Determinable stat on ENV
            if(isset($split[1]) and $split[0] == 'ENV' and function_exists('env'))
                $this->enableTool = (bool) env($split[1]);
            else
                dd('Config::DISABLE_TOOL value string not supported! Check if ENV and value exists', $value, $split);
        }
        else
            dd('Config::DISABLE_TOOL value not supported!', $value);
    }

    /**
     * @return bool
     */
    public function isQueryLog()
    {
        return $this->queryLog;
    }

    /**
     * @param bool $queryLog
     */
    public function setQueryLog($queryLog)
    {
        $this->queryLog = $queryLog;
    }

    /**
     * @return bool
     */
    public function isPointLabelTrim()
    {
        return $this->pointLabelTrim;
    }

    /**
     * @return mixed
     */
    public function getPointLabelLTrim()
    {
        return $this->pointLabelLTrim;
    }

    /**
     * @param string $pointLabelLTrim
     */
    public function setPointLabelLTrim($status)
    {
        $this->pointLabelLTrim = $status;
    }

    /**
     * @return mixed
     */
    public function getPointLabelRTrim()
    {
        return $this->pointLabelRTrim;
    }

    /**
     * @param string $pointLabelRTrim
     */
    public function setPointLabelRTrim($status)
    {
        $this->pointLabelRTrim = $status;
    }

    /**
     * @return mixed
     */
    public function getPresenterType()
    {
        return $this->presenterType;
    }

    /**
     * @param mixed $presenterType
     */
    public function setPresenterType($presenterType)
    {
        $this->presenterType = $presenterType;
    }

}