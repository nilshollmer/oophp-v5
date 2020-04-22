<?php

namespace Nihl\Dice100;

/**
 * Class for holding dice objects, rolling dice and calculating results
 */

class DiceHand
{
    /**
     * @var integer hand        Array of values of dice
     */
     protected $handValues;
     protected $handGraphic;

    /**
     * Roll dice according to the number of dice to roll
     *
     * @param int $numDice      Number of dice to throw, default 2
     *
     * @return void
     */
    public function rollHand(int $numDice = 2)
    {
        $this->handValues = [];
        $this->handGraphic = [];

        for ($i = 0; $i < $numDice; $i++) {
            $newDice = new Dice();
            array_push($this->handValues, $newDice->roll());
            array_push($this->handGraphic, $newDice->graphic());
        }
    }


    /**
     * Check if dice array contains a dice with value 1
     *
     *
     * @return boolean
     */
    public function handContainsOne()
    {
        return in_array(1, $this->handValues);
    }

    /**
     * Return the graphical representations of the dice
     *
     * @return array            Array of strings
     */
    public function getGraphicHand()
    {
        return $this->handGraphic;
    }

    /**
     * Returns sum of the hand of dice as an integer
     *
     * @return int             Sum of the hand
     */
    public function sumOfHand()
    {
        return array_sum($this->handValues);
    }
}
