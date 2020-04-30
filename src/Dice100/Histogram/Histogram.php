<?php

namespace Nihl\Dice100;

/**
 * Generating Histogram data
 */

class Histogram
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

    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Inject the object to use as base for histogram data
     *
     * @param HistogramInterface    $object The object holding the serie
     *
     * @return void
     */
    public function injectData(HistogramInterface $object)
    {
        $this->serie    =   $object->getHistogramSerie();
        $this->min      =   $object->getHistogramMin();
        $this->max      =   $object->getHistogramMax();
    }



    /**
     * Get histogram as text
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        return "Histogramserie";
    }
}
