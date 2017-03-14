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

        echo '<style>';
        include_once 'DisplayHtml.css';
        echo '</style>';

        echo '<div class="performance">
            <table class=\'table-title\'>
                <tr>
                    <td width="50%">' . $this->formatter->memoryToHuman( $this->masterPoints->getDifferenceMemory() ) . '</td>
                    <td width="50%">' . $this->formatter->timeToHuman( $this->masterPoints->getDifferenceTime() )  .  '</td>
                </tr>
            </table>
            
            <div class="overflow">
            <table width="100%">
            <tr>
                <th width="20%">Label</th>
                <th width="20%">Time</th>
                <th width="20%">Memory usage</th>
                <th width="20%">Memory peak</th>
                <th width="20%">Memory max</th>
            </tr>
            </table>
            <table width="100%">';

            foreach ($this->points as $point)
            {
                echo '<tr>';
                    echo '<td width="20%">' . $point->getLabel() . '</td>';
                    echo '<td width="20%">' . $this->formatter->timeToHuman( $point->getDifferenceTime() ). '</td>';
                    echo '<td width="20%">' . $this->formatter->memoryToHuman( $point->getDifferenceMemory() ). '</td>';
                    echo '<td width="20%">' . $this->formatter->memoryToHuman( $point->getMemoryPeak() ). '</td>';
                    echo '<td width="20%">' . $this->formatter->memoryToHuman( $point->getStopMemoryUsage() ). '</td>';
                echo '</tr>';
            }
            
        echo '</div>';
    }

    private function displayAsFileOutput()
    {

    }

    private function displayForWebAsConsole()
    {
        $data = [];
        foreach ($this->points as $point)
        {

            $data[] = [
                'label' => $point->getLabel(),
                'time' => $this->formatter->timeToHuman( $point->getDifferenceTime() ),
                'memory_usage' => $this->formatter->memoryToHuman( $point->getDifferenceMemory() ),
                'memory_peak' => $this->formatter->memoryToHuman( $point->getStopMemoryUsage() ),
            ];
        }

//        dd(json_encode($data), 1,$this->points);


        echo "<script>console.log(" . json_encode($data) .")</script>";
    }

}