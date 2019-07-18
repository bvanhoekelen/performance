<?php

declare(strict_types=1);

namespace Performance\Lib\Presenters;

use Performance\Lib\Holders\CalculateTotalHolder;
use Performance\Lib\Point;

class Calculate
{
    /**
     * Calculate total memory
     *
     * return Performance\Lib\Holders\CalculateTotalHolder;
     * @param Point[] $pointStack
     * @return CalculateTotalHolder
     */
    public function totalTimeAndMemory($pointStack):CalculateTotalHolder
    {
        $max_time = 0;
        $max_memory = 0;

        foreach (array_slice($pointStack, 2) as $point) {
            $max_time += $point->getDifferenceTime();
            $max_memory += $point->getDifferenceMemory();
        }

        return new CalculateTotalHolder($max_time, $max_memory, memory_get_peak_usage(true));
    }

    /**
     * Calculate percentage
     *
     * @param $pointDifference
     * @param $total
     * @return float
     */
    public function calculatePercentage($pointDifference, $total): float
    {
        $upCount = 1000000;
        $percentage = 0.0;

        if ($pointDifference > 0 && $total > 0) {
            $percentage = round((100 * $pointDifference * $upCount) / ($total * $upCount));
        }

        return $percentage;
    }
}
