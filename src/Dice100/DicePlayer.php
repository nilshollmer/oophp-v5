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
    private static $playerNumber = 1;
    private $name;
    private $totalPoints;


    /**
     * Instanciate player with name and 0 points
     *
     * @param string name       Name of player
     */
    public function __construct(string $name = null)
    {
        $this->name = $name ? $name : "player" . self::$playerNumber++;
        $this->totalPoints = 0;
    }

    /**
     * Get player name
     *
     * @return string           Name of player
     */
    public getName()
    {
        return $this->name;
    }

    /**
     * Get player points
     *
     * @return integer          Player points
     */
    public getTotalPoints()
    {
        return $this->totalPoints;
    }

    /**
     * Add player points
     *
     * @param int       $points Points to add
     * @return void
     */
    public addPoints(int $points)
    {
        $this->totalPoints += $points;
    }

    /**
     * Returns true if players total points is greater than or equal to 100
     * else false
     *
     * @return boolean
     */
    public hasWon()
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
