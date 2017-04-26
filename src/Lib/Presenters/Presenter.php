<?php namespace Performance\Lib\Presenters;

use Performance\Lib\Handlers\ConfigHandler;
use Performance\Lib\Point;
use Performance\Lib\Presenters\Display\CommandLineDisplay;
use Performance\Lib\Presenters\Display\WebDisplay;

class Presenter {

    // Set print format
    const PRESENTER_COMMAND_LINE = 1;
    const PRESENTER_WEB = 2;

    // Config
    protected $config;

    // Display
    private $display;

    public function __construct(ConfigHandler $config)
    {
        $this->config = $config;

        // Choose display format
        $this->setDisplay();
    }

    /*
     * Passed trigger to results to display
     */
    public function displayResults($pointStack)
    {
        $this->display->displayResults($pointStack);
    }

    /*
     * Passed trigger finish point to display
     */
    public function finishPointTrigger(Point $point)
    {
        $this->display->displayFinishPoint($point);
    }

    /*
     * Set display
     */
    private function setDisplay()
    {
        if($this->config->getPresenterType() == self::PRESENTER_COMMAND_LINE)
            $this->display = new CommandLineDisplay($this->config);
        elseif($this->config->getPresenterType() == self::PRESENTER_WEB)
            $this->display = new WebDisplay($this->config);
        else
            dd('Unknown presenter type', $this->config->getPresenterType());
    }
}