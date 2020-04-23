<?php

namespace Nihl\Dice100;

/**
 * Class for Dice
 */

class Dice
{
    /**
     * @var integer SIDES       Number of sides on the dice
     * @var integer lastRoll    Value of the last rolled dice
     */
    const SIDES = 6;
    private $lastRoll;

     /**
      * Roll the dice and get a random result
      *
      * @return int             Number between 1 and 6
      */
    public function roll()
    {
        $this->lastRoll = rand(1, self::SIDES);
        return $this->lastRoll;
    }

    /**
     * Get a graphical representation of the last dice
     *
     * @return string
     */
    public function graphic()
    {
        return "dice-" . $this->lastRoll;
    }
}
