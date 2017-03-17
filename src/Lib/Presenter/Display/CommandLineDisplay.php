<?php namespace Performance\Lib\Presenter\Display;

use Performance\Lib\PerformanceHandler;
use Performance\Lib\Point;

class CommandLineDisplay extends Display implements DisplayInterface
{
    private $firstCommandLineMessage = false;
    private $commandLineWidth;
    private $commandLineHeight;

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

        $this->printPointLine($point->getLabel(), $point->getDifferenceTime(), $point->getDifferenceMemory());
    }

    public function displayResults(Point $masterPoint, $pointStack)
    {
        $this->masterPoint = $masterPoint;
        $this->pointStage = $pointStack;

        $this->printFinishDown();
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


        echo PHP_EOL;
        echo "  ___          __                                " . PHP_EOL;
        echo " | _ \___ _ _ / _|___ _ _ _ __  __ _ _ _  __ ___ " . PHP_EOL;
        echo " |  _/ -_) '_|  _/ _ \ '_| '  \/ _` | ' \/ _/ -_)" . PHP_EOL;
        echo " |_| \___|_| |_| \___/_| |_|_|_\__,_|_||_\__\___|" . PHP_EOL;
        echo PHP_EOL;
        echo " Create by B. van hoekelen " . $this->color('green', 'v' . PerformanceHandler::VERSION)  . " PHP " . $this->color('green', 'v'. phpversion()) . PHP_EOL;
        echo " Max memory " . ini_get("memory_limit") . " max, execution time " . ini_get('max_execution_time') . " sec on " . date('Y-m-d H:i:s') . PHP_EOL;
        echo PHP_EOL;

        // Print head
        $this->printHeadLine();

    }

    private function printFinishDown()
    {
        echo str_repeat("-", $this->commandLineWidth) . PHP_EOL;
        echo "   " . str_pad("Total " . count($this->pointStage)
                . " taken", $this->commandLineWidth - 35)
                . "   " . str_pad(" Time", 12, ' ',STR_PAD_LEFT)
                . "   " . str_pad("  Memory", 12, ' ', STR_PAD_LEFT) .  PHP_EOL;
        echo PHP_EOL;

    }

    private function printHeadLine()
    {
        echo "   " . str_pad("Label", $this->commandLineWidth - 35) . "   " . str_pad(" Time", 12) . "   " . str_pad("  Memory", 12) .  PHP_EOL;
        echo str_repeat("-", $this->commandLineWidth) . PHP_EOL;
    }

    private function printPointLine($label, $time, $memory)
    {
        echo " > "
            . str_pad(mb_strimwidth($label, 0, 42, '..'), $this->commandLineWidth - 35)
            . " -"
            . $this->formatter->stringPad( $this->formatter->timeToHuman( $time ), 14, " ")
            . " -"
            . str_pad( $this->formatter->memoryToHuman( $memory ) , 14, " ", STR_PAD_LEFT) . PHP_EOL;
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