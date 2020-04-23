<?php

namespace Nihl\Dice100;

/**
 * Player class for Dice100 game
 *
 */

class DicePlayer
{
    /**
     * @var string  name        Name of player
     * @var integer totalPoints Total points
     */
    private const BASENAME = "Player";
    protected $name;
    protected $totalPoints;


    /**
     * Instanciate player with name and 0 points
     *
     * @param string name       Name of player
     */
    public function __construct(string $name = null)
    {
        $this->name = $name ? $name : self::BASENAME . rand(1000, 9999);
        $this->totalPoints = 0;
    }

    /**
     * Get player name
     *
     * @return string           Name of player
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get player points
     *
     * @return integer          Player points
     */
    public function getTotalPoints()
    {
        return $this->totalPoints;
    }

    /**
     * Add player points
     *
     * @param int       $points Points to add
     * @return void
     */
    public function addPoints(int $points)
    {
        $this->totalPoints += $points;
    }

    /**
     * Returns true if players total points is greater than or equal to 100
     * else false
     *
     * @return boolean
     */
    public function hasWon()
    {
        return $this->totalPoints >= 100;
    }

    /**
     * Roll a hand of dice and return the sum,
     * If hand contains a value equal to 1, -1 is returned
     *
     * @param dicehand $diceHand object
     *
     */
    public rollHand($diceHand)
    {
        $diceHand->rollDice();

        if ($diceHand->handContainsOne()) {
            return -1;
        }
        return $diceHand->sumOfHand();
    }
}
