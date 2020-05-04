<?php

namespace Nihl\Dice100;

/**
 * Interface for classes supporting histogram reports
 * Use with HistogramTrait
 */

interface HistogramInterface
{
    /**
     * Get the serie
     *
     * @return array with the serie
     */
    public function getHistogramSerie();
}
