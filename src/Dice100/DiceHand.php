<?php

namespace Nihl\Dice100;

/**
 * Class for holding dice objects, rolling dice and calculating results
 */

class DiceHand
{
    /**
     * @var integer diceInHand  Number of dice in hand
     * @var integer handValues  Array of integer values
     * @var integer handGraphic Array of string values
     */
    protected $diceInHand;
    protected $handValues;
    protected $handGraphic;

    /**
     * Setup number of dice in hand
     *
     * @param integer numDice number of dice in hand, default to 2
     */
    public function __construct(int $numDice = 2)
    {
        $this->diceInHand = $numDice;
    }

    /**
     * Roll dice according to the number of dice to roll
     *
     * @param int $numDice      Number of dice to throw
     *
     * @return void
     */
    public function rollDice()
    {
        $this->handValues = [];
        $this->handGraphic = [];

        for ($i = 0; $i < $this->diceInHand; $i++) {
            $dice = new Dice();
            array_push($this->handValues, $dice->roll());
            array_push($this->handGraphic, $dice->graphic());
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
     * Return the amount of dice in hand
     *
     * @return int              Number of dice
     */
    public function getDiceInHand()
    {
        return $this->diceInHand;
    }

    /**
     * Return the graphical representations of the dice
     *
     * @return array            Array of strings
     */
    public function getHandGraphic()
    {
        return $this->handGraphic;
    }

    /**
     * Return the values in hand
     *
     * @return array            Array of integers
     */
    public function getHandValues()
    {
        return $this->handValues;
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
