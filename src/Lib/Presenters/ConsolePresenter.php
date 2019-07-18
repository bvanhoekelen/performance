<?php

declare(strict_types=1);

namespace Performance\Lib\Presenters;

use Performance\Lib\Handlers\PerformanceHandler;
use Performance\Lib\Holders\QueryLineHolder;
use Performance\Lib\Point;
use function str_pad;
use function str_repeat;

/**
 * Class ConsolePresenter
 * @package Performance\Lib\Presenters
 */
class ConsolePresenter extends Presenter
{
    const TIME_MS = 'ms';

    /**
     * @var
     */
    protected $commandLineWidth;

    /**
     * @var
     */
    protected $commandLineHeight;

    /**
     * @var
     */
    protected $cellWightResult;

    /**
     * @var
     */
    protected $cellWightLabel;

    /**
     * @var array
     */
    private $printStack = [];


    public function bootstrap():void
    {
        $this->printStartUp();
    }

    protected function printStartUp(): void
    {
        // Get size
        $this->setCommandSize();
        if ($this->config->isClearScreen()) {
            $this->clearScreen();
        }

        // Live indication
        $liveIndication = ($this->config->isConsoleLive()) ? terminal_style(' LIVE ', 'gray', 'red') : '';

        // Query log indication
        $queryLogIndication = '';
        if ($this->config->queryLogState === true) {
            $queryLogIndication = terminal_style(' QUERY ', 'gray', 'black');
        } elseif ($this->config->queryLogState === false) {
            $queryLogIndication = terminal_style(' QUERY NOT ACTIVE ', 'gray', 'yellow', 'bold');
        }

        // Execution time
        $textExecutionTime = (ini_get('max_execution_time') > 1) ? ini_get('max_execution_time') . ' sec' : 'unlimited';

        // Print art
        $this->liveOrStack(PHP_EOL
            . " " . terminal_style('     PHP PERFORMANCE TOOL     ', null,
                'gray') . $queryLogIndication . $liveIndication . PHP_EOL
            . " Created by B. van Hoekelen version " . PerformanceHandler::VERSION . " PHP v" . phpversion() . PHP_EOL
            . " Max memory " . ini_get("memory_limit") . ", max execution time " . $textExecutionTime . " on " . date('Y-m-d H:i:s') . PHP_EOL
        );

        // Print run information
        if ($this->config->isRunInformation()) {
            $this->liveOrStack(" Run by user " . $this->information->getCurrentUser() . " on process id " . $this->information->getCurrentProcessId() . PHP_EOL);
        }

        // Set new line
        $this->liveOrStack(PHP_EOL);

        // Print head
        $this->printHeadLine();

    }

    protected function setCommandSize(): void
    {
        $this->commandLineWidth = exec('tput cols');
        $this->commandLineHeight = exec('tput lines');

        if ($this->commandLineWidth < 60) {
            $this->commandLineWidth = 60;
        }
        if ($this->commandLineWidth > 140) {
            $this->commandLineWidth = 140;
        }

        /**
         *  |<------------------------------- ( Terminal wight ) ---------------------------------->|
         *  | <---------------- (38 - wight) ---------------><---------------- 39 --------------->| | < terminal border
         *  |    Label                                       .    Time    .   Memory   .    Peak    |
         *  | ------------------------------------------------------------------------------------- |
         *  |  > Calibrate point long label text long label..|   <-12->   |   <-12->   |  <-11->    |
         *  |  > Task 1                                      | 9999.99 μs | 9999.99 KB | 9999.99 MB |
         *  | ------------------------------------------------------------------------------------- |
         *  |    Total 7 taken                                 9999.97 ms   9999.00 MB   9999.99 MB |
         *  |
         */

        $this->cellWightResult = 12;
        $this->cellWightLabel = $this->commandLineWidth - 40;
    }

    /**
     * Executed clear screen command
     */
    protected function clearScreen(): void
    {
        $command = 'clear';

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $command = 'cls';
        }

        system($command);
    }

    /**
     * @param $line
     */
    protected function liveOrStack($line): void
    {
        if ($this->config->isConsoleLive()) {
            echo $line;
        } else {
            $this->printStack[] = $line;
        }
    }

    protected function printHeadLine(): void
    {
        $string = str_pad("   Label", $this->cellWightLabel);
        $string .= ' ' . str_pad('Time', $this->cellWightResult, ' ', STR_PAD_BOTH);
        $string .= ' ' . str_pad('Memory', $this->cellWightResult, ' ', STR_PAD_BOTH);
        $string .= ' ' . str_pad('Peak', $this->cellWightResult, ' ', STR_PAD_BOTH) . PHP_EOL;
        $string .= str_repeat("-", $this->commandLineWidth - 1) . PHP_EOL;

        $this->liveOrStack($string);
    }

    /**
     * @param Point $point
     * @return bool
     * @throws FormatterException
     */
    public function finishPointTrigger(Point $point): bool
    {
        // Preload and calculate
        if ($point->getLabel() === Point::POINT_PRELOAD || $point->getLabel() === Point::POINT_MULTIPLE_PRELOAD) {
            return false;
        }

        $string = str_pad(mb_strimwidth(" > " . $point->getLabel(), 0, $this->cellWightLabel, '..'),
            $this->cellWightLabel);
        $string .= ' ' . $this->formatter->stringPad(($point->isMultiplePoint() ? '~' : '') . $this->formatter->timeToHuman($point->getDifferenceTime()) . ' ',
                $this->cellWightResult, ' ');
        $string .= '|' . str_pad($this->formatter->memoryToHuman($point->getDifferenceMemory()) . ' ',
                $this->cellWightResult, " ", STR_PAD_LEFT);
        $string .= '|' . str_pad($this->formatter->memoryToHuman($point->getMemoryPeak()) . ' ', $this->cellWightResult,
                " ", STR_PAD_LEFT) . PHP_EOL;

        $this->liveOrStack($string);

        // Print query log resume
        /** @var QueryLineHolder $queryLineHolder */
        foreach ($this->formatter->createPointQueryLogLineList($point) as $queryLineHolder) {
            $this->printMessage($queryLineHolder->getLine(), $queryLineHolder->getTime() . ' ' . self::TIME_MS . ' ');
        }

        // Print point new line message
        $this->printPointNewLineMessage($point);

        return true;
    }

    /**
     * @param null $message
     * @param string $time
     * @param string $memory
     * @param string $peak
     */
    public function printMessage($message = null, $time = '-- ', $memory = '-- ', $peak = '-- ')
    {
        $this->liveOrStack(terminal_style(str_pad(mb_strimwidth("   " . $message, 0, $this->cellWightLabel, '..'),
                    $this->cellWightLabel)
                . ' ' . str_pad($time, $this->cellWightResult, ' ', STR_PAD_LEFT)
                . '|' . str_pad($memory, $this->cellWightResult, ' ', STR_PAD_LEFT)
                . '|' . str_pad($peak, $this->cellWightResult, ' ', STR_PAD_LEFT), 'dark-gray') . PHP_EOL);
    }

    /**
     * @param Point $point
     */
    protected function printPointNewLineMessage(Point $point): void
    {
        if (count($point->getNewLineMessage())) {
            foreach ($point->getNewLineMessage() as $message) {
                $this->printMessage($message);
            }
        }
    }

    /**
     * @param $pointStack
     * @throws FormatterException
     */
    public function displayResultsTrigger($pointStack): void
    {
        $this->pointStack = $pointStack;
        $this->printFinishDown();
        $this->printStack();
    }


    /**
     * @throws FormatterException
     */
    protected function printFinishDown(): void
    {
        $calculateTotalHolder = $this->calculate->totalTimeAndMemory($this->pointStack);
        $spacer = ' ';
        $padLength = $this->cellWightLabel;

        if ($this->commandLineWidth > 80) {
            $padLength = $this->cellWightLabel - 15;
            $spacer = ' ';
        }

        $a = str_pad("   Total " . (count($this->pointStack) - 2) . " taken ", $padLength) . $spacer;

        $this->liveOrStack(str_repeat("-", $this->commandLineWidth - 1) . PHP_EOL
            . $a
            . " " . $this->formatter->stringPad($this->formatter->timeToHuman($calculateTotalHolder->totalTime) . ' ',
                $this->cellWightResult, ' ')
            . " " . str_pad($this->formatter->memoryToHuman($calculateTotalHolder->totalMemory) . ' ',
                $this->cellWightResult, ' ', STR_PAD_LEFT)
            . " " . str_pad($this->formatter->memoryToHuman($calculateTotalHolder->totalMemoryPeak) . ' ',
                $this->cellWightResult, ' ', STR_PAD_LEFT)
            . PHP_EOL
            . PHP_EOL);
    }

    protected function printStack(): void
    {
        if (!$this->config->isConsoleLive()) {
            foreach ($this->printStack as $line) {
                echo $line;
            }
        }
    }
}
