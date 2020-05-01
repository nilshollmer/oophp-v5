<?php

namespace Nihl\Dice100;

/**
 * Generating Histogram data
 */

class Histogram
{
    /**
     * @var array   $serie      Numbers stored in sequence
     * @var int     $min        The lowest possible number
     * @var int     $max        The highest possible number
     */
    private $serie = [];
    private $rolls = [];
    private $min = 1;
    private $max = 6;

    /**
     * Create the object and initialize rolls array to an array of Zeros
     *
     */
    public function __construct()
    {
        foreach (range($this->min, $this->max) as $key) {
            $this->rolls[$key] = "";
        }
    }

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
        $serie = $object->getHistogramSerie();
        foreach ($serie as $key) {
            $this->rolls[$key] .= "*";
        }
        array_unshift($this->serie, $serie);
    }


    /**
     * Get statistics of rolls from the game
     *
     * @return string representing the histogram.
     */
    public function getStatistics()
    {
        $output = "";

        foreach (array_keys($this->rolls) as $key) {
            $output .= "<p>" . $key . ": " . $this->rolls[$key] . "</p>";
        }

        return $output;
    }

    /**
     * Get the last individual rolls
     *
     * @return string representing the histogram.
     */
    public function getAsText()
    {
        $output = "";
        $sizeOfOutput = 6;

        foreach (array_slice($this->serie, 0, $sizeOfOutput) as $hand) {
            $output .= "<p>" . implode(", ", $hand) . "</p>";
        }

        return $output;
    }
}
