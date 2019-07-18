<?php

declare(strict_types=1);

namespace Performance\Lib\Interfaces;

/**
 * Interface ExportInterface
 * @package Performance\Lib\Interfaces
 */
interface ExportInterface
{
    /**
     * Simple export function
     *
     * @return  array
     */
    public function export(): array;
}