<?php namespace Performance\Lib\Handlers;

use Performance\Lib\Interfaces\ExportInterface;
use Performance\Lib\Presenters\Presenter;

class ConfigHandler implements ExportInterface
{
    // Config items
    protected $consoleLive = false;
    protected $enableTool = true;
    protected $queryLog = false;
    protected $queryLogView;
    protected $pointLabelLTrim = false;
    protected $pointLabelRTrim = false;
    protected $pointLabelNice = false;
    protected $runInformation = false;
    protected $clearScreen = true;
    protected $presenter;

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

    protected function setDefaultConsoleLive()
    {
        $shortopts = 'l::';
        $longopts = ['live'];
        $options = getopt($shortopts, $longopts);

        // Set live option
        if(isset($options['l']) or isset($options['live']))
            $this->consoleLive = true;
    }

    // Print format
    protected function setDefaultPresenter()
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
            else{
            	print_r($split);
                die('Config::DISABLE_TOOL value string "' . $value . '" not supported! Check if ENV and value exists' . PHP_EOL);
            }
        }
        else
	        die('Config::DISABLE_TOOL value "' . $value . '" not supported!' . PHP_EOL);
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
    protected function setQueryLogView($queryLogView = null)
    {
        if($queryLogView == 'resume' or ! $queryLogView)
            $this->queryLogView = 'resume';
        elseif($queryLogView == 'full')
            $this->queryLogView = $queryLogView;
        else
            die('Query log view ' . $queryLogView . ' does not exists. Use: "resume" or "full"' . PHP_EOL);
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
                die('Presenter ' . $mixed . ' does not exists. Use: console or web' . PHP_EOL);
    }

    /**
     * @return bool
     */
    public function isPointLabelNice()
    {
        return $this->pointLabelNice;
    }

    /**
     * @param bool $pointLabelNice
     */
    public function setPointLabelNice($pointLabelNice)
    {
        $this->pointLabelNice = (bool) $pointLabelNice;
    }

    /**
     * Set run information
     * @param bool $status
     */
    public function setRunInformation($status)
    {
        $this->runInformation = (bool) $status;
    }

    /**
     * @return bool
     */
    public function isRunInformation()
    {
        return $this->runInformation;
    }

	/**
	 * @return bool
	 */
	public function isClearScreen() {
		return $this->clearScreen;
	}

	/**
	 * @param bool $clearScreen
	 */
	public function setClearScreen($clearScreen) {
		$this->clearScreen = (bool) $clearScreen;
	}
}
