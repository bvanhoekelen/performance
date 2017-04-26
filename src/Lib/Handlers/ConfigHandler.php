<?php namespace Performance\Lib\Handlers;

use Performance\Lib\Interfaces\ExportInterface;
use Performance\Lib\Presenters\Presenter;

class ConfigHandler implements ExportInterface
{
    // Config items
    private $consoleLive = false;
    private $enableTool = true;
    private $queryLog = false;
    private $queryLogView;
    private $pointLabelLTrim = false;
    private $pointLabelRTrim = false;
    private $presenter;

    /*
     * Hold state of the query log
     * null = not set
     * false = config is false
     * true = query log is set
     */
    public $queryLogState;

    public function __construct()
    {
        // Set default
        $this->setDefaultTimeZone();
        $this->setDefaultConsoleLive();
        $this->setDefaultPresenter();
    }

    /*
     * Simple export function
     */
    public function export()
    {
        return get_object_vars($this);
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
            $this->consoleLive = true;
    }

    // Print format
    private function setDefaultPresenter()
    {
        if (php_sapi_name() == "cli")
            $this->setPresenter(Presenter::PRESENTER_CONSOLE);
        else
            $this->setPresenter(Presenter::PRESENTER_WEB);
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
    public function setQueryLog($queryLog, $viewOption = null)
    {
        $this->queryLog = $queryLog;
        $this->setQueryLogView($viewOption);
    }

    /**
     * @return mixed
     */
    public function getQueryLogView()
    {
        return $this->queryLogView;
    }

    /**
     * @param mixed $queryLogView
     */
    private function setQueryLogView($queryLogView = null)
    {
        if($queryLogView == 'resume' or ! $queryLogView)
            $this->queryLogView = 'resume';
        elseif($queryLogView == 'full')
            $this->queryLogView = $queryLogView;
        else
            dd('Query log view ' . $queryLogView . ' does not exists. Use: "resume" or "full"');
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
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * @param mixed $presenter
     */
    public function setPresenter($mixed)
    {
        if(is_int($mixed))
            $this->presenter = $mixed;
        else
            if($mixed == 'console')
                $this->presenter = Presenter::PRESENTER_CONSOLE;
            elseif($mixed == 'web')
                $this->presenter = Presenter::PRESENTER_WEB;
            else
                dd('Presenter ' . $mixed . ' does not exists. Use: console or web');
    }

}