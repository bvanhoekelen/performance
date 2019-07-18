<?php

declare(strict_types=1);

namespace Performance\Lib\Handlers;

use Exception;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Performance\Lib\Holders\QueryLogHolder;
use Performance\Lib\Point;
use Performance\Lib\Presenters\ConsolePresenter;
use Performance\Lib\Presenters\Presenter;
use Performance\Lib\Presenters\WebPresenter;
use RuntimeException;

/**
 * Class PerformanceHandler
 * @package Performance\Lib\Handlers
 */
class PerformanceHandler
{
    /**
     * Version
     */
    const VERSION = '2.5.0';

    /**
     * Hold the query log items
     */
    public $queryLogStack = [];

    /**
     * Hold the config class
     */
    public $config;

    /**
     * Store current point
     *
     * @var Point
     */
    protected $currentPoint;

    /**
     * Hold point stack
     */
    protected $pointStack = [];

    /**
     * Hold sub point stack
     */
    protected $multiPointStack = [];

    /**
     *  Hold presenter
     *
     * @var Presenter
     */
    protected $presenter;

    /**
     *
     */
    protected $messageToLabel = null;

    /**
     * PerformanceHandler constructor.
     */
    public function __construct()
    {
        // Set config
        $this->config = new ConfigHandler();
    }

    /**
     * @throws Exception
     */
    public function bootstrap()
    {
        $this->setConfigQueryLogState();

        // Set display
        $this->bootstrapDisplay();

        // Preload class point
        $this->preload();
    }

    /**
     * Check if query log is possible
     */
    protected function setConfigQueryLogState()
    {
        // Check if state is set
        if (!is_null($this->config->queryLogState)) {
            return;
        }

        // Set check query log state
        if ($this->config->isQueryLog()) {
            $this->config->queryLogState = false;

            // Check if DB class exists
            if (!class_exists('\Illuminate\Support\Facades\DB')) {
                return;
            }

            // Resister listener
            try {
                DB::listen(function ($sql)
                {
                    $this->queryLogStack[] = new QueryLogHolder($sql);
                });
                $this->config->queryLogState = true;
            } catch (RuntimeException $e) {
                try {
                    Manager::listen(function ($sql)
                    {
                        $this->queryLogStack[] = new QueryLogHolder($sql);
                    });
                    $this->config->queryLogState = true;

                } catch (RuntimeException $e) {
                    $this->config->queryLogState = false;
                }
            }
        }
    }

    /**
     * @throws PerformanceException
     */
    protected function bootstrapDisplay()
    {
        if ($this->config->getPresenter() === Presenter::PRESENTER_CONSOLE) {
            $this->presenter = new ConsolePresenter($this->config);
        } elseif ($this->config->getPresenter() === Presenter::PRESENTER_WEB) {
            $this->presenter = new WebPresenter($this->config);
        } else {
            throw new PerformanceException("Unknown presenter '" . $this->config->getPresenter() . "'");
        }
    }

    /**
     * Preload wil setup te point class
     */
    protected function preload()
    {
        $this->point(Point::POINT_PRELOAD);
        $this->point(Point::POINT_MULTIPLE_PRELOAD, true);
        $this->finish(POINT::POINT_MULTIPLE_PRELOAD); // Needs!
        $this->point(Point::POINT_CALIBRATE);
    }

    /**
     * Set measuring point X
     *
     * @param string|null $label
     * @param bool $isMultiplePoint
     * @return void
     */
    public function point($label = null, $isMultiplePoint = false)
    {
        // Check if point already exists
        if (!$isMultiplePoint) {
            $this->finishLastPoint();
        }

        // Check sub point
        $this->checkIfPointLabelExists($label, $isMultiplePoint);

        // Set label
        if (is_null($label)) {
            $label = 'Task ' . (count($this->pointStack) - 1);
        }

        // Create point
        $point = new Point($this->config, $label, $isMultiplePoint);

        // Create and add point to stack
        if ($isMultiplePoint) {
            $this->multiPointStack[ $label ] = $point;
            $this->message('Start multiple point ' . $label);
        } else {
            $this->currentPoint = $point;
        }

        // Start point
        $point->start();
    }

    /**
     * Finish all point in the stack
     *
     * @return void
     */
    protected function finishLastPoint()
    {
        // Measurements are more accurate
        $stopTime = microtime(true);

        if ($this->currentPoint) {
            // Get point
            $point = $this->currentPoint;

            if ($point->isActive()) {
                // Set query log items
                $this->setQueryLogItemsToPoint($point);

                // Check if message in label text
                $this->checkAndSetMessageInToLabel($point);

                // Finish point
                $point->setStopTime($stopTime);
                $point->finish();

                $this->pointStack[] = $point;

                // Trigger presenter listener
                $this->presenter->finishPointTrigger($point);
            }
        }
    }

    /**
     * Move query log items to point
     * @param Point $point
     */
    protected function setQueryLogItemsToPoint(Point $point)
    {
        // Skip if query log is disabled
        if ($this->config->queryLogState !== true) {
            return;
        }

        $point->setQueryLog($this->queryLogStack);
        $this->queryLogStack = [];
    }

    /**
     * Update point label with message
     * @param Point $point
     */
    protected function checkAndSetMessageInToLabel(Point $point)
    {
        if (!$this->messageToLabel) {
            return;
        }

        // Update label
        $point->setLabel($point->getLabel() . " - " . $this->messageToLabel);

        // Reset
        $this->messageToLabel = '';
    }

    /**
     * Check if label already exists
     * @param $label
     * @param $isMultiPoint
     */
    protected function checkIfPointLabelExists($label, $isMultiPoint)
    {
        $labelExists = false;
        $stack = ($isMultiPoint) ? $this->multiPointStack : $this->pointStack;
        foreach ($stack as $point) {
            if ($point->getLabel() === $label) {
                $labelExists = true;
                break;
            }
        }

        if ($labelExists) {
            throw new InvalidArgumentException("label '" . $label . "' already exists, choose new point label.");
        }
    }

    /**
     * Set message
     *
     * @param string|null $message
     * @param boolean|null $newLine
     * @return void
     */
    public function message($message, $newLine = true)
    {
        $point = $this->currentPoint;

        // Skip
        if (!$point || !$point->isActive()) {
            return;
        }

        if ($newLine) {
            $point->addNewLineMessage($message);
        } else {
            $this->messageToLabel .= $message;
        }
    }

    /**
     * Finish measuring point X
     *
     * @param string|null $multiplePointLabel
     * @return void
     */
    public function finish($multiplePointLabel = null)
    {
        $this->finishLastPoint();

        if ($multiplePointLabel) {
            if (!isset($this->multiPointStack[ $multiplePointLabel ])) {
                throw new InvalidArgumentException("Can't finish multiple point '" . $multiplePointLabel . "'.");
            }

            $point = $this->multiPointStack[ $multiplePointLabel ];
            unset($this->multiPointStack[ $multiplePointLabel ]);

            if ($point->isActive()) {
                // Finish point
                $point->finish();

                // Trigger presenter listener
                $this->presenter->finishPointTrigger($point);
            }

            //
            $this->pointStack[] = $point;

        }
    }

    /**
     * Return test results
     *
     * @return ExportHandler
     */
    public function results()
    {
        // Finish all
        $this->finishLastPoint();

        // Finish all multiple points
        $this->finishAllMultiplePoints();

        // Add results to presenter
        $this->presenter->displayResultsTrigger($this->pointStack);

        // Return export
        return $this->export();
    }

    protected function finishAllMultiplePoints()
    {
        // Measurements are more accurate
        $stopTime = microtime(true);

        if (count($this->multiPointStack)) {
            foreach ($this->multiPointStack as $point) {
                $point->setStopTime($stopTime);
                $point->finish();
                $this->pointStack[] = $point;

                // Trigger presenter listener
                $this->presenter->finishPointTrigger($point);
            }
        }
    }

    /**
     * @return ExportHandler
     */
    public function export()
    {
        return new ExportHandler($this);
    }

    /**
     * @return array
     */
    public function getPoints()
    {
        return $this->pointStack;
    }
}
