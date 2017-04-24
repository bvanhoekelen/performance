<?php namespace Performance\Lib;

use Performance\Lib\Presenter\Display\CommandLineDisplay;
use Performance\Lib\Presenter\Display\WebDisplay;

class Presenter {

    // Set print format
    const PRINT_FORMAT_COMMAND_LINE = 1;
    const PRINT_FORMAT_WEB = 2;

    public $printFormat;
    private $display;
    protected $config;

    public function __construct(ConfigHandler $config)
    {
        $this->config = $config;

        // Check date function
        if( ! ini_get('date.timezone') )
            date_default_timezone_set('UTC');

        // Choose display format
        $this->setPrintFormat();
        $this->setDisplay();
    }

    // Triggers
    public function displayResults($pointStack)
    {
        $this->display->displayResults($pointStack);
    }

    public function finishPointTrigger(Point $point)
    {
        $this->display->displayFinishPoint($point);
    }

    // Print format
    private function setPrintFormat()
    {
        if (php_sapi_name() == "cli")
            $this->printFormat = self::PRINT_FORMAT_COMMAND_LINE;
        else
            $this->printFormat = self::PRINT_FORMAT_WEB;
    }

    // Display
    private function setDisplay()
    {
        if($this->printFormat == self::PRINT_FORMAT_COMMAND_LINE)
            $this->display = new CommandLineDisplay($this->config);
        else
            $this->display = new WebDisplay($this->config);
    }
}