<?php

namespace Nihl\Dice100;

/**
 * Class for DiceComputer, extends DicePlayer
 */

class DiceComputer extends DicePlayer
{
    /**
     * @var BASENAME    basename of computer
     */
    private const BASENAME = "Computer";

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->name = self::BASENAME . rand(1000, 9999);
        $this->totalPoints = 0;
    }

    /**
     * Checks value of hand against total points and calculates whether to
     * roll och hold
     *
     * @return Boolean
     */
    public function calculateMove() : boolean
    {
        // if $this->getTotalPoints() >
    }
}
