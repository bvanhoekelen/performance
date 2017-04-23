<?php namespace Performance\Lib\Presenter\Display;

use Performance\Lib\PerformanceHandler;
use Performance\Lib\Point;

class WebDisplay extends Display
{
    public function displayStartPoint(Point $point)
    {
    }

    public function displayFinishPoint(Point $point)
    {

    }

    public function displayResults($pointStack)
    {
        $this->pointStage = $pointStack;
        $this->updateTotalTimeAndMemory();
        $this->displayForWebAsHtml();
        $this->displayForWebAsConsole();
    }

    // Private

    private function displayForWebAsConsole()
    {
        $data = [];
        foreach ($this->pointStage as $point)
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

    private function displayForWebAsHtml()
    {
        // Set total time
        echo '<style>';
        include_once 'DisplayHtml.css';
        echo '</style>';

        echo '<div class="performance">';
            if(count($this->pointStage) > 2)
            {
                $textExecutionTime = (ini_get('max_execution_time') > 1) ? ini_get('max_execution_time') . ' sec' : 'unlimited';

                echo'<table class="table-title">
                    <tr>
                        <td width="50%">' . $this->formatter->memoryToHuman($this->totalMemory) . '<br><span>Max memory ' . ini_get("memory_limit") . '</span></td>
                        <td width="50%">' . $this->formatter->timeToHuman($this->totalTime) . '<br><span>Max time ' . $textExecutionTime . ' on PHP ' . phpversion() . '</span></td>
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
                    </tr>';

                    foreach (array_slice($this->pointStage, 1) as $point) {

                        // For real calibrate results fake printing
                        if( $point->getLabel() === Point::POINT_CALIBRATE )
                            continue;

                        echo '<tr>'
                            . '<td class="t-l">' . $point->getLabel() . '</td>'
                            . '<td>' . $this->formatter->timeToHuman($point->getDifferenceTime()) . '</td>'
                            . '<td>' . $this->calculatProcens($point->getDifferenceTime(), $this->totalTime) . '</td>'
                            . '<td>' . $this->formatter->memoryToHuman($point->getDifferenceMemory()) . '</td>'
                            . '<td>' . $this->calculatProcens($point->getDifferenceMemory(), $this->totalMemory) . '</td>'
                            . '<td>' . $this->formatter->memoryToHuman($point->getMemoryPeak()) . '</td>'
                            . '</tr>';


                        if(count($point->getNewLineMessage()))
                        {
                            foreach ($point->getNewLineMessage() as $message)
                            {
                                echo '<tr><td class="new-line-message" colspan="6">' . $message . '</td></tr>';
                            }
                        }
                    }
                    echo '</table>';

                    $calibratePoint = $this->pointStage[1];

                    echo '<div class="table-more-info">Performance v' . PerformanceHandler::VERSION
                        . ' PHP v' . phpversion() . ' on ' . date('Y-m-d H:i:s')
                        . '<br>Calibrate point: '
                        . $this->formatter->timeToHuman($calibratePoint->getDifferenceTime())
                        . '</div>';
                echo '</div>';
            }
            else
                echo '<div class="table-more-info"> <h2>There are not point set</h2>Set your first point with <var>point</var> command:<br><code>Performance::point()</code>Final you can view the results with the <var>results</var> command:<br><code>Performance::results()</code></div>';
        echo '</div>';
    }

    public function printMessage($message = null)
    {
        // TODO: Implement printMessage() method.
    }
}