<?php namespace Performance\Lib\Presenters;

use Performance\Lib\Handlers\ConfigHandler;
use Performance\Lib\Point;
use Performance\Lib\Presenters\Display\CommandLineDisplay;
use Performance\Lib\Presenters\Display\WebDisplay;

class Presenter {

    // Set print format
    const PRESENTER_CONSOLE = 1;
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
        if($this->config->getPresenter() == self::PRESENTER_CONSOLE)
            $this->display = new CommandLineDisplay($this->config);
        elseif($this->config->getPresenter() == self::PRESENTER_WEB)
            $this->display = new WebDisplay($this->config);
        else
            dd('Unknown presenter ', $this->config->getPresenter());
    }
}