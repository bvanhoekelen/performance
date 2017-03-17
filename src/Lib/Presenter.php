<?php namespace Performance\Lib;

use Performance\Lib\Presenter\Display\CommandLineDisplay;
use Performance\Lib\Presenter\Display\WebDisplay;

class Presenter {

    // Set print format
    const PRINT_FORMAT_COMMAND_LINE = 1;
    const PRINT_FORMAT_WEB = 2;

    public $printFormat;
    private $display;

    public function __construct()
    {
        // Check date function
        if( ! ini_get('date.timezone') )
            date_default_timezone_set('UTC');

        // Choose display format
        $this->setPrintFormat();
        $this->setDisplay();
    }

    public function displayResults(Point $masterPoint, $pointStack)
    {
        $this->display->displayResults($masterPoint, $pointStack);
    }

    public function startPointTrigger(Point $point)
    {
        $this->display->displayStartPoint($point);
    }

    public function finishPointTrigger(Point $point)
    {
        $this->display->displayFinishPoint($point);
    }

    private function setPrintFormat()
    {
        if (php_sapi_name() == "cli")
            $this->printFormat = self::PRINT_FORMAT_COMMAND_LINE;
        else
            $this->printFormat = self::PRINT_FORMAT_WEB;
    }

    private function setDisplay()
    {
        if($this->printFormat == self::PRINT_FORMAT_COMMAND_LINE)
            $this->display = new CommandLineDisplay();
        else
            $this->display = new WebDisplay();
    }
}