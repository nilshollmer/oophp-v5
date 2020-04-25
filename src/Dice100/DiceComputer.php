<?php

namespace Nihl\Dice100;

/**
 * Class for DiceComputer, extends DicePlayer
 */

class DiceComputer extends DicePlayer
{
    /**
     * Constructor for computer
     */
    public function __construct()
    {
        $this->type = "Computer";
        $this->name = $this->type . rand(1000, 9999);
        $this->totalPoints = 0;
    }

    /**
     * Checks value of hand against currentPoints and calculates whether to
     * roll och hold
     *
     * @return Boolean
     */
    public function calculateMove($currentPoints) : bool
    {
        $threshold = 16;
        $winning = 100;

        if (($this->totalPoints + $currentPoints) >= $winning) {
            return false;
        }

        if ($currentPoints > $threshold) {
            return false;
        }

        return true;
    }
}
