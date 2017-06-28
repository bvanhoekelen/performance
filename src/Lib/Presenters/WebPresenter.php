<?php namespace Performance\Lib\Presenters;

use Performance\Lib\Handlers\PerformanceHandler;
use Performance\Lib\Point;

class WebPresenter extends Presenter
{
    public function bootstrap()
    {}

    public function finishPointTrigger(Point $point)
    {}

    public function displayResultsTrigger($pointStack)
    {
        $this->pointStack = $pointStack;

        $this->displayForWebAsHtml();
        $this->displayForWebAsConsole();
    }

    // Private
    private function displayForWebAsConsole()
    {
        $data = [];
        $data['config'] = $this->config->export();
        foreach ($this->pointStack as $point)
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
            if(count($this->pointStack) > 2)
            {
                $textExecutionTime = (ini_get('max_execution_time') > 1) ? ini_get('max_execution_time') . ' sec' : 'unlimited';
                $calculateTotalHolder = $this->calculate->totalTimeAndMemory($this->pointStack);

                echo'<table class="table-title">
                    <tr>
                        <td width="50%">' . $this->formatter->memoryToHuman($calculateTotalHolder->totalMemory) . '<br><span>Max memory ' . ini_get("memory_limit") . '</span></td>
                        <td width="50%">' . $this->formatter->timeToHuman($calculateTotalHolder->totalTime) . '<br><span>Max time ' . $textExecutionTime . ' on PHP ' . phpversion() . '</span></td>
                    </tr>
                </table>
                
                <div class="overflow">
                
                    <table class="table-point">
                    <tr>
                        <th>Label</th>
                        <th width="5%">%</th>
                        <th width="17%">Memory</th>
                        <th width="5%">%</th>
                        <th width="17%">Time</th>
                    </tr>';

                    foreach (array_slice($this->pointStack, 1) as $point) {

                        // For real calibrate results fake printing
                        if( $point->getLabel() === Point::POINT_CALIBRATE )
                            continue;

                        echo '<tr>'
                            . '<td class="t-l">' . $point->getLabel() . '</td>'
                            . '<td>' . $this->calculate->calculatePercentage($point->getDifferenceMemory(), $calculateTotalHolder->totalMemory) . '</td>'
                            . '<td>' . $this->formatter->memoryToHuman($point->getDifferenceMemory()) . '</td>'
                            . '<td>' . $this->calculate->calculatePercentage($point->getDifferenceTime(), $calculateTotalHolder->totalTime) . '</td>'
                            . '<td>' . $this->formatter->timeToHuman($point->getDifferenceTime()) . '</td>'
                            . '</tr>';

                        foreach ($point->getQueryLog() as $queryLogHolder)
                        {
                            echo '<tr>';
                            echo'<td class="new-line-message" colspan="4"> - ' . ((strlen($queryLogHolder->query) > 70) ? substr($queryLogHolder->query,0,67).'...' : $queryLogHolder->query) . '</td>';
                            echo'<td class="new-line-message" style="text-align: right;" colspan="1">' . $queryLogHolder->time . ' ms</td>';
                            echo '</tr>';
                        }

                        foreach ($point->getNewLineMessage() as $message)
                        {
                            echo '<tr><td class="new-line-message" colspan="5">' . $message . '</td></tr>';
                        }
                    }
                    echo '</table>';

                    $calibratePoint = $this->pointStack[1];

                    echo '<div class="table-more-info">Performance v' . PerformanceHandler::VERSION
                        . ' PHP v' . phpversion() . ' on ' . date('Y-m-d H:i:s')
                        . '<br>Calibrate point: ' . $this->formatter->timeToHuman($calibratePoint->getDifferenceTime());

                    if($this->config->isRunInformation())
                        echo "<br> Run by user " . $this->information->getCurrentUser() . " on process id " . $this->information->getCurrentProcessId();

                    echo '</div>';
                echo '</div>';
            }
            else
                echo '<div class="table-more-info"> <h2>There are not point set</h2>Set your first point with <var>point</var> command:<br><code>Performance::point()</code>Final you can view the results with the <var>results</var> command:<br><code>Performance::results()</code></div>';
        echo '</div>';
    }
}