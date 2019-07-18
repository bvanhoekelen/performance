<?php

declare(strict_types=1);

namespace Performance\Lib\Presenters;

use Performance\Lib\Handlers\ConfigHandler;
use Performance\Lib\Holders\InformationHolder;
use Performance\Lib\Point;

/**
 * Class Presenter
 * @package Performance\Lib\Presenters
 */
abstract class Presenter
{

    /**
     *
     */
    const PRESENTER_CONSOLE = 1;

    /**
     *
     */
    const PRESENTER_WEB = 2;

    // Config

    /**
     * @var ConfigHandler
     */
    protected $config;

    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @var Calculate
     */
    protected $calculate;

    /**
     * @var
     */
    protected $pointStack;

    /**
     * @var InformationHolder
     */
    protected $information;

    /**
     * Presenter constructor.
     * @param ConfigHandler $config
     */
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
     *
     * @param $pointStack
     */
    abstract public function displayResultsTrigger($pointStack): void;

    /**
     * Passed trigger finish point to display
     * @param Point $point
     * @return bool
     */
    abstract public function finishPointTrigger(Point $point): bool;
}
