<?php

declare(strict_types=1);

namespace Performance\Lib\Handlers;

use function env;
use function explode;
use function function_exists;
use function get_object_vars;
use InvalidArgumentException;
use function is_bool;
use function is_int;
use function is_string;
use Performance\Lib\Interfaces\ExportInterface;
use Performance\Lib\Presenters\Presenter;
use function php_sapi_name;
use function print_r;


/**
 * Class ConfigHandler
 * @package Performance\Lib\Handlers
 */
class ConfigHandler implements ExportInterface
{
    // Config items
    /**
     * Hold state of the query log
     * null = not set
     * false = config is false
     * true = query log is set
     */
    public $queryLogState;

    /**
     * @var bool
     */
    protected $consoleLive = false;

    /**
     * @var bool
     */
    protected $enableTool = true;

    /**
     * @var bool
     */
    protected $queryLog = false;

    /**
     * @var
     */
    protected $queryLogView;

    /**
     * @var bool
     */
    protected $pointLabelLTrim = false;

    /**
     * @var bool
     */
    protected $pointLabelRTrim = false;

    /**
     * @var bool
     */
    protected $pointLabelNice = false;

    /**
     * @var bool
     */
    protected $runInformation = false;

    /**
     * @var bool
     */
    protected $clearScreen = true;

    /**
     * @var
     */
    protected $presenter;

    /**
     * ConfigHandler constructor.
     */
    public function __construct()
    {
        // Set default
        $this->setDefaultConsoleLive();
        $this->setDefaultPresenter();
    }

    protected function setDefaultConsoleLive()
    {
        $shortOpts = 'l::';
        $longOpts = ['live'];
        $options = getopt($shortOpts, $longOpts);

        // Set live option
        if (isset($options[ 'l' ]) || isset($options[ 'live' ])) {
            $this->consoleLive = true;
        }
    }

    protected function setDefaultPresenter()
    {
        if (php_sapi_name() === "cli") {
            $this->setPresenter(Presenter::PRESENTER_CONSOLE);
        } else {
            $this->setPresenter(Presenter::PRESENTER_WEB);
        }
    }

    /**
     * @inheritDoc
     *
     * @return array
     */
    public function export(): array
    {
        $vars = get_object_vars($this);
        return $vars ?? [];
    }

    /**
     * @return bool
     */
    public function isConsoleLive()
    {
        return $this->consoleLive;
    }

    /**
     * @param $status
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
     * @param $value
     * @throws ConfigException
     */
    public function setEnableTool($value)
    {
        if (is_bool($value)) {
            $this->enableTool = $value;
        } elseif (is_string($value)) {
            $split = explode(':', $value);

            // Determinable stat on ENV
            if (isset($split[ 1 ]) && $split[ 0 ] === 'ENV' && function_exists('env')) {
                $this->enableTool = (bool)env($split[ 1 ]);
            } else {
                print_r($split);
                throw new ConfigException('Config::DISABLE_TOOL value string ' . $value . ' not supported! Check if ENV and value exists.');
            }
        } else {
            throw new ConfigException('Config::DISABLE_TOOL value ' . $value . ' not supported!');
        }
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
     * @param null $viewOption
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
        if ($queryLogView === 'resume' || !$queryLogView) {
            $this->queryLogView = 'resume';
        } elseif ($queryLogView === 'full') {
            $this->queryLogView = $queryLogView;
        } else {
            throw new InvalidArgumentException('Query log view ' . $queryLogView . ' does not exists, use: \'resume\' or \'full\'');
        }
    }

    /**
     * @return bool
     */
    public function getPointLabelLTrim(): bool
    {
        return $this->pointLabelLTrim;
    }

    /**
     * @param $status
     * @return ConfigHandler
     */
    public function setPointLabelLTrim($status): self
    {
        $this->pointLabelLTrim = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPointLabelRTrim(): bool
    {
        return $this->pointLabelRTrim;
    }

    /**
     * @param $status
     * @return ConfigHandler
     */
    public function setPointLabelRTrim($status): self
    {
        $this->pointLabelRTrim = $status;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPresenter()
    {
        return $this->presenter;
    }

    /**
     * @param $mixed
     * @return ConfigHandler
     */
    public function setPresenter($mixed): self
    {
        if (is_int($mixed)) {
            $this->presenter = $mixed;
        } elseif ($mixed === 'console') {
            $this->presenter = Presenter::PRESENTER_CONSOLE;
        } elseif ($mixed === 'web') {
            $this->presenter = Presenter::PRESENTER_WEB;
        } else {
            throw new InvalidArgumentException('Presenter ' . $mixed . ' does not exists. Use: console or web.');
        }

        return $this;
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
    public function setPointLabelNice(bool $pointLabelNice)
    {
        $this->pointLabelNice = $pointLabelNice;
    }

    /**
     * @return bool
     */
    public function isRunInformation()
    {
        return $this->runInformation;
    }

    /**
     * Set run information
     * @param bool $status
     */
    public function setRunInformation(bool $status)
    {
        $this->runInformation = $status;
    }

    /**
     * @return bool
     */
    public function isClearScreen()
    {
        return $this->clearScreen;
    }

    /**
     * @param bool $clearScreen
     */
    public function setClearScreen(bool $clearScreen)
    {
        $this->clearScreen = $clearScreen;
    }
}
