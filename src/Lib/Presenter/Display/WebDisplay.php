<?php namespace Performance\Lib\Presenter\Display;

use Performance\Lib\Presenter\Formatter;
use Performance\Lib\Point;
use Performance\Lib\Presenter;

class WebDisplay extends Display
{
    public function displayStartPoint(Point $point)
    {
    }

    public function displayFinishPoint(Point $point)
    {

    }

    public function displayResults(Point $masterPoint, $pointStack)
    {
        $this->masterPoint = $masterPoint;
        $this->pointStage = $pointStack;
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

        // Set total time
        $this->updateTotalTimeAndMemory();

        foreach ($this->pointStage as $point)
        {
            echo '<tr>';
            echo '<td class="t-l">' . $point->getLabel() . '</td>';
            echo '<td>' . $this->formatter->timeToHuman( $point->getDifferenceTime() ). '</td>';
            echo '<td>' . $this->calculatProcens($point->getDifferenceTime(), $this->totalTime) . '</td>';
            echo '<td>' . $this->formatter->memoryToHuman( $point->getDifferenceMemory() ) . '</td>';
            echo '<td>' . $this->calculatProcens($point->getDifferenceMemory(), $this->totalMemory) . '</td>';
            echo '<td>' . $this->formatter->memoryToHuman( $point->getMemoryPeak() ). '</td>';
            echo '<td>' . $this->formatter->memoryToHuman( $point->getStopMemoryUsage() ). '</td>';
            echo '</tr>';
        }

        echo '</div>';
    }

}