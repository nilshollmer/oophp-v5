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
     * Roll the dice and set lastRoll variable to result
     *
     * @return void
     */
    public function roll()
    {
        $this->setLastRoll(rand(1, self::SIDES));
    }

    /**
     * Update last roll with value
     *
     * @param integer $value
     *
     */
    public function setLastRoll($value)
    {
        $this->lastRoll = $value;
    }

    /**
     * Fetch last roll
     *
     * @return integer          Last roll
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
