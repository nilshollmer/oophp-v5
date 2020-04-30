<?php

namespace Nihl\Dice100;

/**
 * Trait for implementing HistogramInterface
 */

trait HistogramTrait
{
    /**
     * @var array   $serie      Numbers stored in sequence
     */
    private $serie = [];


    /**
     * Get the serie
     *
     * @return array with serie
     */
    public function getHistogramSerie()
    {
        return $this->serie;
    }
}
