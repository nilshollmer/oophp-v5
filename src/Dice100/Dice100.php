<?php

namespace Nihl\Dice100;

/**
 *
 */

class Dice100
{
    /**
     * @var string      $players    Players and computers in the game
     * @var int         $numOfDice  Number of dice used
     * @var DiceHand    $diceHand   Dicehand used to roll
     * @var array       $gamestate  Array of variables that change during the game
     */

    private $players;
    private $numOfDice;
    private $diceHand;
    private $gamestate;

    /**
     * Initialize game with variables that don't change during the game
     *
     * @param int       $numDice    Number of dice used in the game
     *
     * @return void
     */
    public function __construct(int $numDice = 2)
    {
        $this->players = [];
        $this->numOfDice = $numDice;
        $this->diceHand = new DiceHand($this->numOfDice);
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
            "diceHand" => "",
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
     * Main game function
     * Takes following commands: "Roll", "Hold", "Pass", "Next Turn"
     *
     * "Roll"       Roll dice and accumulate points, dice of 1 ends turn.
     * "Hold"       Save accumulated points for the active player and check
     *              if they have won.
     * "Next Turn"  End the turn, change active player and reset turn related variables.
     * "Pass"       Make a choice based on calculateMove function,
     *              Used by computer player.
     *
     * @return void
     */
    public function runGame($command)
    {
        switch ($command) {
            case "Roll":
                $this->rollHand();
                break;
            case "Hold":
                $this->holdHand();
                $this->checkWinner();
                break;
            case "Next Turn":
                $this->moveTurnCounter();
                $this->startNextTurn();
                break;
            case "Pass":
                $move = $this->gamestate["active"]->calculateMove($this->gamestate["currentPoints"]);
                if ($move) {
                    $this->rollHand();
                    break;
                }

                $this->holdHand();
                $this->checkWinner();
                break;
        }
    }

    /**
     * Change turn by resetting variables and changing active player
     *
     * @return void
     */
    private function startNextTurn()
    {
        $this->gamestate["currentPoints"] = 0;
        $this->gamestate["diceHand"] = "";
        $this->gamestate["turnIsOver"] = false;
        $this->gamestate["active"] = $this->getPlayer($this->gamestate["turnCounter"]);
    }

    /**
     * Add accumulated points to the active players totalPoints and end the turn
     *
     * @return void
     */
    private function holdHand()
    {
        $this->gamestate["active"]->addPoints($this->gamestate["currentPoints"]);
        $this->gamestate["turnIsOver"] = true;
    }

    /**
     * Roll diceHand
     * If diceHand contains a value equal to 1, end the turn
     * Else, Add diceHand sum to "currentPoints" variable
     * Finally, Update "diceHand" variable
     *
     * @return void
     */
    private function rollHand()
    {
        $this->diceHand->rollDice();

        if ($this->diceHand->handContainsOne()) {
            $this->endTurn();
        } else {
            $this->gamestate["currentPoints"] += $this->diceHand->sumOfHand();
        }

        $this->gamestate["diceHand"] = $this->getDiceHand();
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
     * Check if active player has accumulated 100 points or more.
     * If true, change "hasWon" variable to active player
     *
     * @return void
     */
    private function checkWinner()
    {
        if ($this->gamestate["active"]->hasWon()) {
            $this->gamestate["hasWon"] = $this->gamestate["active"];
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

    /**
     * Fetches array of all players
     *
     * @return string Values separated by ", "
     */
    public function getDiceHand()
    {
        return $this->diceHand->getHandValues();
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
}
