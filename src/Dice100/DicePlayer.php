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
    private static $instanceOfObject = 0;
    protected $name;
    protected $totalPoints;


    /**
     * Instanciate player with name and 0 points
     *
     * @param string name       Name of player
     */
    public function __construct(string $name = null)
    {
        self::$instanceOfObject++;
        $this->name = $name ? $name : "player" . self::$instanceOfObject;
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

    // /**
    //  *
    //  */
    // public rollHand()
    // {
    //     return $this->totalPoints >= 100;
    // }
}
