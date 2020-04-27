<?php

namespace Nihl\Dice100;

/**
 * Main game class
 *
 * API:
 * initGamestate()  Initiates gamestate variable
 * createPlayers()  Adds a player and a number of computers to the $players array
 *
 * checkHand()      Takes a diceHand object as argument and checks if it
 *                  contains 1 or not and acts accordingly.
 * holdHand()       Takes points in currentPoints variable and adds to
 *                  active player, checks if they have won and ends the turn.
 * startNextTurn()  End the turn, change active player and reset turn related variables.
 * computerMove()   Calls computers calculateMove method and returns boolean
 * resetPlayers()   Reset player points
 *
 * getGamestate()   returns gamestate variable
 * getPlayer()      Returns a player using index
 * getPlayers()     Returns all player
 */

class Dice100
{
    /**
     * @var string      $players    Players and computers in the game
     * @var array       $gamestate  Array of variables that change during the game
     */

    private $players;
    private $gamestate;

    /**
     * Initialize game with variables that don't change during the game
     *
     *
     * @return void
     */
    public function __construct()
    {
        $this->players = [];
        $this->gamestate = [];
    }

    /**
     * Initialize gamestate array
     *
     * @return void
     */
    public function initGamestate()
    {
        $this->gamestate = [
            "turnCounter" => 0,
            "turnIsOver" => false,
            "hasWon" => null,
            "active" => $this->players[0],
            "currentPoints" => 0
        ];
    }

    /**
     * Basic player creation
     *
     * @param string    $name       Name of player
     * @param int       $comp       Number of computers
     *
     * @return void
     */
    public function createPlayers($name = "", $comp = 1)
    {
        $this->players[] = new DicePlayer($name);
        for($i = 0; $i < $comp; $i++) {
            $this->players[] = new DiceComputer();
        }
    }

    /**
     * Call Computer calculateMove method
     *
     * @return boolean
     */
    public function computerMove()
    {
        if ($this->gamestate["active"]->getType() == "Computer") {
            return $this->gamestate["active"]->calculateMove($this->gamestate["currentPoints"]);
        }
        return false;
    }

    /**
     * Change turn by resetting variables and changing active player
     *
     * @return void
     */
    public function startNextTurn()
    {
        $this->moveTurnCounter();
        $this->gamestate["currentPoints"] = 0;
        $this->gamestate["turnIsOver"] = false;
        $this->gamestate["active"] = $this->getPlayer($this->gamestate["turnCounter"]);
    }

    /**
     * Add accumulated points to the active players totalPoints
     * Check if player has won
     * end the turn
     *
     * @return void
     */
    public function holdHand()
    {
        $this->gamestate["active"]->addPoints($this->gamestate["currentPoints"]);
        $this->checkWinner($this->gamestate["active"]);
        $this->endTurn();
    }

    /**
     * Check if diceHand contains a value equal to 1, end the turn
     * Else, Add diceHand sum to "currentPoints" variable
     *
     * @param DiceHand $diceHand
     *
     * @return void
     */
    public function checkHand($diceHand)
    {
        if ($diceHand->handContainsOne()) {
            $this->endTurn();
        } else {
            $this->addDiceHandToCurrentPoints($diceHand);
        }
    }

    /**
     * Add diceHand sum to "currentPoints" variable
     *
     * @param DiceHand $diceHand
     *
     * @return void
     */
    private function addDiceHandToCurrentPoints($diceHand)
    {
        $this->gamestate["currentPoints"] += $diceHand->sumOfHand();
    }


    /**
     * Augment "turnCounter" variable
     * If "turnCounter" is greater than the amount of players, set it to 0
     *
     * @return void
     */
    private function moveTurnCounter()
    {
        $this->gamestate["turnCounter"]++;
        if ($this->gamestate["turnCounter"] >= count($this->players)) {
            $this->gamestate["turnCounter"] = 0;
        }
    }

    /**
     * Change "turnIsOver" variable to true
     *
     * @return void
     */
    private function endTurn()
    {
        $this->gamestate["turnIsOver"] = true;
    }

    /**
     * Check if a player has accumulated 100 points or more.
     * If true, change "hasWon" variable to active player
     *
     * @param Player $player object
     *
     * @return void
     */
    private function checkWinner($player)
    {
        if ($player->hasWon()) {
            $this->gamestate["hasWon"] = $player;
        }
    }

    /**
     * Fetches array of gamestate variables
     *
     * @return array Array of gamestate variables
     */
    public function getGamestate()
    {
        return $this->gamestate;
    }

    /**
     * Reset player scores
     *
     * @return void
     */
    public function resetPlayers()
    {
        foreach ($this->players as $player) {
            $player->setTotalPoints(0);
        }
    }
    /**
     * Fetches a player object
     *
     * @return Player
     */
    public function getPlayer(int $index)
    {
        return $this->players[$index];
    }

    /**
     * Fetches array of all players
     *
     * @return array Array of players
     */
    public function getPlayers()
    {
        return $this->players;
    }
}
