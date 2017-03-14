<?php namespace Performance\Lib;

class Presenter {

    private $points;
    private $masterPoint;
    private $formatter;

    public function __construct()
    {

    }

    public function setResults(PerformanceHandler $performanceHandler)
    {
        $this->points = $performanceHandler->getPoints();
        $this->masterPoint = $performanceHandler->getMasterPoint();
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
            <table class="table-title">
                <tr>
                    <td width="50%">' . $this->formatter->memoryToHuman( $this->masterPoint->getDifferenceMemory() ) . '<br><span>Max memory ' . ini_get("memory_limit") . '</span></td>
                    <td width="50%">' . $this->formatter->timeToHuman( $this->masterPoint->getDifferenceTime() )  .  '<br><span>Max time ' . ini_get('max_execution_time') . ' sec</span></td>
                </tr>
            </table>
            
            <div class="overflow">
            
            <table class="table-point">
            <tr>
                <th width="20%">Label</th>
                <th width="17%">Time</th>
                <th width="5%">%</th>
                <th width="17%">Memory usage</th>
                <th width="5%">%</th>
                <th width="18%">Memory peak</th>
                <th width="18%">Memory max</th>
            </tr>';

            $max_time = 0;
            $max_memory = 0;

            foreach ($this->points as $point)
            {
                $max_time += $point->getDifferenceTime();
                $max_memory += $point->getDifferenceMemory();
            }

            $max_time = $max_time * 1000000;
            $max_memory = $max_memory * 1000000;


            foreach ($this->points as $point)
            {
                echo '<tr>';
                    echo '<td class="t-l">' . $point->getLabel() . '</td>';
                    echo '<td>' . $this->formatter->timeToHuman( $point->getDifferenceTime() ). '</td>';
                    echo '<td>' . round((100 * $point->getDifferenceTime() * 1000000 ) / $max_time) . '</td>';
                    echo '<td>' . $this->formatter->memoryToHuman( $point->getDifferenceMemory() ) . '</td>';
                    if($point->getDifferenceMemory() * 1000000 > 1) echo '<td>' . round((100 * $point->getDifferenceMemory() * 1000000) / $max_memory) . '</td>'; else echo '<td>00</td>';
                    echo '<td>' . $this->formatter->memoryToHuman( $point->getMemoryPeak() ). '</td>';
                    echo '<td>' . $this->formatter->memoryToHuman( $point->getStopMemoryUsage() ). '</td>';
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
                'raw' => $point->export()
            ];
        }
        echo "<script>console.log(" . json_encode($data) .")</script>";
    }

}