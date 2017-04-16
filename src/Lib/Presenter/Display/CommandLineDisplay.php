<?php namespace Performance\Lib\Presenter\Display;

use Performance\Lib\PerformanceHandler;
use Performance\Lib\Point;

class CommandLineDisplay extends Display
{
    private $firstCommandLineMessage = false;
    private $commandLineWidth;
    private $commandLineHeight;
    private $optionLive = false;
    private $printStack = [];

    public function __construct()
    {
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
        $this->liveOrStack($this->printPointLine($point->getLabel(), $point->getDifferenceTime(), $point->getDifferenceMemory(), $point->getMemoryPeak()));
    }

    public function displayResults($pointStack)
    {
        $this->pointStage = $pointStack;
        $this->printFinishDown();
        $this->printStack();
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

    private function setOptions()
    {
        $shortopts = 'l::';
        $longopts = ['live'];
        $options = getopt($shortopts, $longopts);

        // Set live option
        $this->optionLive = (isset($options['l']) or isset($options['live'])) ? true : false;
    }

    private function color($color, $text)
    {
        $colorCode = [];

        $colorCode['black'] = 30;
        $colorCode['red'] = 31;
        $colorCode['green'] = 32;
        $colorCode['yellow'] = 33;
        $colorCode['blue'] = 34;
        $colorCode['purple'] = 35;
        $colorCode['cyan'] = 36;
        $colorCode['white'] = 37;

        if(isset($colorCode[$color]))
            return "\e[" . $colorCode[$color] . "m" . $text . "\e[0m";
        else
            dd("Color " . $color . " not exists", $colorCode);

    }

    private function printStartUp()
    {
        // Get size
        $this->setCommandSize();
        $this->clearScreen();

        // Live indication
        $liveIndication = ($this->optionLive) ? $this->color('red', ' LIVE') : '';

        // Print art
        $this->liveOrStack(PHP_EOL
            . " Created by B. van hoekelen " . $this->color('green', 'v' . PerformanceHandler::VERSION)  . " PHP " . $this->color('green', 'v'. phpversion()) . $liveIndication . PHP_EOL
            . " Max memory " . ini_get("memory_limit") . " max, execution time " . ini_get('max_execution_time') . " sec on " . date('Y-m-d H:i:s') . PHP_EOL
            . PHP_EOL);

        // Print head
        $this->printHeadLine();

    }

    private function printHeadLine()
    {
        $this->liveOrStack("   " . str_pad("Label", $this->commandLineWidth - 42) . "   " . str_pad("   Time", 11) . "   " . str_pad("  Memory", 11) . "   " . str_pad(" Peak", 11) .  PHP_EOL
        . str_repeat("-", $this->commandLineWidth) . PHP_EOL);
    }

    private function printFinishDown()
    {
        $this->updateTotalTimeAndMemory();

        $this->liveOrStack( str_repeat("-", $this->commandLineWidth) . PHP_EOL
            . "   " . str_pad("Total " . (count($this->pointStage) - 2)
                . " taken", $this->commandLineWidth - 42)
                . "  " . $this->formatter->stringPad( $this->formatter->timeToHuman( $this->totalTime ), 11, ' ', STR_PAD_LEFT)
                . "  " . str_pad( $this->formatter->memoryToHuman( $this->totalMemory ), 11, ' ', STR_PAD_LEFT)
                . "  " . str_pad( $this->formatter->memoryToHuman( $this->totalMemoryPeak ), 11, ' ', STR_PAD_LEFT) .  PHP_EOL
            . PHP_EOL);
    }

    private function printPointLine($label, $time, $memoryUsage, $memoryPeak)
    {

        $return = " > "
            . str_pad(mb_strimwidth($label, 0, $this->commandLineWidth - 42, '..'), $this->commandLineWidth - 42)
            . " |"
            . $this->formatter->stringPad( $this->formatter->timeToHuman( $time ), 11, " ")
            . " |"
            . str_pad( $this->formatter->memoryToHuman( $memoryUsage ) , 11, " ", STR_PAD_LEFT)
            . " |"
            . str_pad( $this->formatter->memoryToHuman( $memoryPeak ) , 11, " ", STR_PAD_LEFT) . PHP_EOL;

        // Preload and calculate
        if($label === Point::POINT_PRELOAD)
            return;

        // Return line
        return $return;
    }

    private function setCommandSize()
    {
        $this->commandLineWidth = exec('tput cols');
        $this->commandLineHeight = exec('tput lines');

        if($this->commandLineWidth < 50)
            $this->commandLineWidth = 50;
        if ($this->commandLineWidth > 100)
            $this->commandLineWidth = 100;
    }

    private function clearScreen()
    {
        if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
            system('cls');
        else
            system('clear');
    }


}
