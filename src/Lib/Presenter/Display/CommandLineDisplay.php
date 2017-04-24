<?php namespace Performance\Lib\Presenter\Display;

use Performance\Config;
use Performance\Lib\PerformanceHandler;
use Performance\Lib\Point;

class CommandLineDisplay extends Display
{
    private $firstCommandLineMessage = false;
    private $commandLineWidth;
    private $commandLineHeight;
    private $cellWightResult;
    private $cellWightLabel;
    private $optionLive;            // Load form config

    public function __construct()
    {
        $this->setConfig();
        $this->setOptions();
        parent::__construct();
    }

    public function displayStartPoint(Point $point)
    {
        if( ! $this->firstCommandLineMessage)
        {
            $this->printStartUp();
            $this->firstCommandLineMessage = true;
        }
    }

    public function displayFinishPoint(Point $point)
    {
        // Preload and calculate
        if($point->getLabel() === Point::POINT_PRELOAD)
            return;

        $this->liveOrStack(
            str_pad(mb_strimwidth( " > " . $point->getLabel(), 0, $this->cellWightLabel, '..'), $this->cellWightLabel)
            . ' ' . $this->formatter->stringPad( $this->formatter->timeToHuman( $point->getDifferenceTime() ). ' ', $this->cellWightResult, " ")
            . '|' . str_pad( $this->formatter->memoryToHuman( $point->getDifferenceMemory() ) . ' ', $this->cellWightResult, " ", STR_PAD_LEFT)
            . '|' . str_pad( $this->formatter->memoryToHuman( $point->getMemoryPeak() ) . ' ', $this->cellWightResult, " ", STR_PAD_LEFT) . PHP_EOL);

        // Set message
        if(count($point->getNewLineMessage()))
        {
            foreach ($point->getNewLineMessage() as $message)
            {
                $this->printMessage($message);
            }
        }
    }

    public function displayResults($pointStack)
    {
        $this->pointStage = $pointStack;
        $this->printFinishDown();
        $this->printStack();

        $this->printQueryLogFooter();
    }

    private function liveOrStack($line)
    {
        if($this->optionLive)
            echo $line;
        else
            $this->printStack[] = $line;
    }

    private function printStack()
    {
        if( ! $this->optionLive)
            foreach ($this->printStack as $line)
            {
                echo $line;
            }
    }

    private function setConfig()
    {
        $this->optionLive = Config::get(Config::CONSOLE_LIVE, $this->optionLive);
    }

    private function setOptions()
    {
        $shortopts = 'l::';
        $longopts = ['live'];
        $options = getopt($shortopts, $longopts);

        // Set live option
        if(isset($options['l']) or isset($options['live']))
            $this->optionLive = true;
    }

    private function printStartUp()
    {
        // Get size
        $this->setCommandSize();
        $this->clearScreen();

        // Live indication
        $liveIndication = ($this->optionLive) ? terminal_style(' LIVE ', 'gray', 'red') : '';

        // Query log indication
        $queryLogIndication = (Config::get(Config::QUERY_LOG)) ? terminal_style(' QUERY ', 'gray', 'black') : '';

        // Execution time
        $textExecutionTime = (ini_get('max_execution_time') > 1) ? ini_get('max_execution_time') . ' sec' : 'unlimited';

        // Print art
        $this->liveOrStack(PHP_EOL
            . " " . terminal_style('     PHP PERFORMANCE TOOL     ', null, 'gray') . $queryLogIndication . $liveIndication . PHP_EOL
            . " Created by B. van Hoekelen version " .  PerformanceHandler::VERSION . " PHP v" . phpversion() . PHP_EOL
            . " Max memory " . ini_get("memory_limit") . ", max execution time " . $textExecutionTime . " on " . date('Y-m-d H:i:s') . PHP_EOL
            . PHP_EOL);

        // Print head
        $this->printHeadLine();

    }

    private function printHeadLine()
    {
        $this->liveOrStack(
            str_pad("   Label", $this->cellWightLabel)
            . " " . str_pad('Time', $this->cellWightResult, ' ', STR_PAD_BOTH)
            . " " . str_pad('Memory', $this->cellWightResult, ' ', STR_PAD_BOTH)
            . " " . str_pad('Peak', $this->cellWightResult, ' ', STR_PAD_BOTH) . PHP_EOL
            . str_repeat("-", $this->commandLineWidth - 1) . PHP_EOL);
    }

    private function printFinishDown()
    {
        $this->updateTotalTimeAndMemory();

        if($this->commandLineWidth > 80)
            $a = str_pad("   Total " . (count($this->pointStage) - 2) . " taken ", $this->cellWightLabel - 15) . date('m-d H:i:s') . ' ';
        else
            $a = str_pad("   Total " . (count($this->pointStage) - 2) . " taken ", $this->cellWightLabel);

        $this->liveOrStack( str_repeat("-", $this->commandLineWidth - 1) . PHP_EOL
            . $a
            . " " . $this->formatter->stringPad( $this->formatter->timeToHuman( $this->totalTime ) . ' ', $this->cellWightResult, ' ', STR_PAD_LEFT)
            . " " . str_pad( $this->formatter->memoryToHuman( $this->totalMemory ) . ' ', $this->cellWightResult, ' ', STR_PAD_LEFT)
            . " " . str_pad( $this->formatter->memoryToHuman( $this->totalMemoryPeak ) . ' ', $this->cellWightResult, ' ', STR_PAD_LEFT)
            . PHP_EOL
            . PHP_EOL);
    }

    private function printQueryLogFooter()
    {

//        dd($this->pointStage);

    }

    private function setCommandSize()
    {
        $this->commandLineWidth = exec('tput cols');
        $this->commandLineHeight = exec('tput lines');

        if($this->commandLineWidth < 60)
            $this->commandLineWidth = 60;
        if ($this->commandLineWidth > 100)
            $this->commandLineWidth = 100;

        /*
         *  |<------------------------------- ( Terminal wight ) ---------------------------------->|
         *  | <---------------- (38 - wight) ---------------><---------------- 39 --------------->| | < terminal border
         *  |    Label                                       .    Time    .   Memory   .    Peak    |
         *  | ------------------------------------------------------------------------------------- |
         *  |  > Calibrate point long label text long labe.. |   <-12->   |   <-12->   |  <-11->    |
         *  |  > Task 1                                      | 9999.99 μs | 9999.99 KB | 9999.99 MB |
         *  | ------------------------------------------------------------------------------------- |
         *  |    Total 7 taken                                 9999.97 ms   9999.00 MB   9999.99 MB |
         *  |
         */

        $this->cellWightResult = 12;
        $this->cellWightLabel = $this->commandLineWidth - 40;
    }

    private function clearScreen()
    {
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            system('cls');
        else
            system('clear');
    }

    public function printMessage($message = null)
    {
        $this->liveOrStack(terminal_style(str_pad(mb_strimwidth( "   " . $message, 0, $this->cellWightLabel, '..'), $this->cellWightLabel)
            . ' ' . str_pad('-- ', $this->cellWightResult, ' ', STR_PAD_LEFT)
            . '|' . str_pad('-- ', $this->cellWightResult, ' ', STR_PAD_LEFT)
            . '|' . str_pad('-- ', $this->cellWightResult, ' ', STR_PAD_LEFT) , 'dark-gray'). PHP_EOL );
    }
}
