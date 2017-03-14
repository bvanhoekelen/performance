<?php namespace Performance\Lib;

class Presenter {

    private $points;
    private $masterPoints;
    private $formatter;

    public function __construct()
    {

    }

    public function setResults(PerformanceHandler $performanceHandler)
    {
        $this->points = $performanceHandler->getPoints();
        $this->masterPoints = $performanceHandler->getMasterPoint();
        $this->formatter = new Formatter();
    }

    public function display()
    {
        // Display for command line
        if (php_sapi_name() == "cli") {
            $this->displayForCommandLine();
        } else {
            // Display for web
            $this->displayForWebAsHtml();
            $this->displayForWebAsConsole();

        }
    }

    private function displayForCommandLine()
    {

    }

    private function displayForWebAsHtml()
    {
        dd( getcwd() ,  file_exists('Css\DisplayHtml.css'));

        echo "<style>a</style>";

        echo "<h1>Hoi</h1>";
        echo "<hr>";
        echo "<table width='100%'>";
        echo "<tr>";
            echo "<td width='20%'>Label</td>";
            echo "<td>Time</td>";
            echo "<td>Memory usage</td>";
            echo "<td>Memory peak</td>";
        echo "</tr>";

        foreach ($this->points as $point)
        {
            echo "<tr>";
                echo "<td>" . $point->getLabel() . "</td>";
                echo "<td>" . $this->formatter->timeToHuman( $point->getDifferenceTime() ). "</td>";
                echo "<td>" . $this->formatter->memoryToHuman( $point->getDifferenceMemory() ). "</td>";
                echo "<td>" . $this->formatter->memoryToHuman( $point->getMemoryPeak() ). "</td>";
            echo "</tr>";

        }

        dd($this->points);



    }

    private function displayAsFileOutput()
    {

    }

    private function displayForWebAsConsole()
    {

        echo "<script>console.log(" . json_encode(['tst' => 2]) .")</script>";
    }

}