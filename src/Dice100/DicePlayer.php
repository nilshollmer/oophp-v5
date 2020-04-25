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
    private $type;
    protected $name;
    protected $totalPoints;


    /**
     * Instanciate player with name and 0 points
     *
     * @param string name       Name of player
     */
    public function __construct(string $name = null)
    {
        $this->type = "Player";
        $this->name = $name ? $name : $this->type . rand(1000, 9999);
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
     * Get player type
     *
     * @return string           Type of player
     */
    public function getType()
    {
        return $this->type;
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
     * Set player points
     *
     * @param integer           Player points
     *
     * @return void
     */
    public function setTotalPoints(int $points)
    {
        $this->totalPoints = $points;
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
}
