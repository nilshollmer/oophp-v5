<?php

namespace Nihl\Dice100;

/**
 * Class for holding dice objects, rolling dice and calculating results
 */

class DiceHand implements HistogramInterface
{
    use HistogramTrait;

    /**
     * @var array   diceInHand  Array of Dice
     * @var array   handValues  Array of integer values
     */
    protected $diceInHand;
    protected $handValues;

    /**
     * Setup array of dice
     *
     * @param integer numDice number of dice in hand, default to 2
     */
    public function __construct(int $numDice = 2)
    {
        $this->diceInHand = [];
        $this->handValues = [];

        for ($i = 0; $i < $numDice; $i++) {
            $this->diceInHand[] = new Dice();
        }
    }

    /**
     * Roll dice according to the number of dice to roll
     *
     *
     * @return void
     */
    public function rollDice()
    {
        $this->handValues = [];
        foreach ($this->diceInHand as $dice) {
            $dice->roll();
            $this->addToHandValues($dice->getLastRoll());
        }
        $this->serie = $this->handValues;
    }

    /**
     * Add a value to the end of handValues array
     *
     * @param integer   $value      Value to add to array
     */
    public function addToHandValues($value)
    {
        $this->handValues[] = $value;
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
     * Return the values in hand
     *
     * @return array            Array of integers
     */
    public function getHandValues()
    {
        return $this->handValues;
    }

    /**
     * Return the values in hand
     *
     * @return array            Array of integers
     */
    public function getDiceHandAsString()
    {
        return implode(", ", $this->handValues);
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
