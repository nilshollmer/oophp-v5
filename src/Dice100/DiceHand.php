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
     */
    protected $diceInHand;

    /**
     * Setup array of dice
     *
     * @param integer numDice number of dice in hand, default to 2
     */
    public function __construct(int $numDice = 2)
    {
        $this->diceInHand = [];

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
        $this->serie = [];
        foreach ($this->diceInHand as $dice) {
            $dice->roll();
            $this->addToSerie($dice->getLastRoll());
        }
    }

    /**
     * Add a value to the end of serie array
     *
     * @param integer   $value      Value to add to array
     */
    public function addToSerie($value)
    {
        $this->serie[] = $value;
    }

    /**
     * Check if dice array contains a dice with value 1
     *
     *
     * @return boolean
     */
    public function handContainsOne()
    {
        return in_array(1, $this->serie);
    }

    /**
     * Return the values in hand
     *
     * @return array            Array of integers
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Return the dice in hand
     *
     * @return array            Array of integers
     */
    public function getDiceInHand()
    {
        return $this->diceInHand;
    }

    /**
     * Return the values in hand
     *
     * @return array            Array of integers
     */
    public function getDiceHandAsString()
    {
        $output = "";
        foreach ($this->serie as $dice) {
            $output .= '<i class="dice-sprite dice-' . $dice . '"></i>';
        }


        return $output;
        return implode(", ", $this->serie);
    }

    /**
     * Returns sum of the hand of dice as an integer
     *
     * @return int             Sum of the hand
     */
    public function sumOfHand()
    {
        return array_sum($this->serie);
    }
}
