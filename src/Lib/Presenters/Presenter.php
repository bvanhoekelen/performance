<?php namespace Performance\Lib\Presenters;

use Performance\Lib\Handlers\ConfigHandler;
use Performance\Lib\Holders\InformationHolder;
use Performance\Lib\Point;

abstract class Presenter {

    // Set print format
    const PRESENTER_CONSOLE = 1;
    const PRESENTER_WEB = 2;

    // Config
    protected $config;
    protected $formatter;
    protected $calculate;
    protected $pointStack;
    protected $information;

    public function __construct(ConfigHandler $config)
    {
        $this->config = $config;
        $this->formatter = new Formatter($config);
        $this->calculate = new Calculate();
        $this->information = new InformationHolder($config);

        // Choose display format
        $this->bootstrap();
    }

    /**
     * Bootstrap sub class
     */
    abstract public function bootstrap();

    /**
     * Passed trigger to results to display
     */
    abstract public function displayResultsTrigger($pointStack);

    /**
     * Passed trigger finish point to display
     */
    abstract public function finishPointTrigger(Point $point);
}
