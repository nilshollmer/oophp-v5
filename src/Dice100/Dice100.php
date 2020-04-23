<?php

namespace Nihl\Dice100;

/**
 *
 */

class Dice100
{
    /**
     * @var players
     * @var numOfDice
     */

    private $players;
    private $numOfDice;
    private $diceHand;

    public function __construct()
    {
        $this->players = [];
        $this->numOfDice = 2;
        $this->diceHand = new DiceHand($this->numOfDice);
    }

    public function createPlayers($name)
    {
        $this->players[] = new DicePlayer($name);
        $this->players[] = new DiceComputer();
    }

    public function runGame($name)
    {
        $this->players[] = new DicePlayer($name);
        $this->players[] = new DiceComputer();
    }
}
