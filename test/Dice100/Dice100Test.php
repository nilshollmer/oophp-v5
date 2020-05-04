<?php

namespace Nihl\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Testing main class of Dice100 game
 *
 *
 */
class Dice100Test extends TestCase
{
    /**
     * Create guess variable used in test cases
     */
    protected $game;
    protected $diceHand;

    /**
     * Construct object
     * Create players
     * Initialize gamestate
     */
    protected function setUp() : void
    {
        $this->game = new Dice100();
        $this->diceHand = new DiceHand();
        $this->assertInstanceOf("Nihl\Dice100\Dice100", $this->game);
        $this->game->createPlayers();
        $this->game->initGamestate();
    }

    /**
     * Verify gamestate variables
     *
     * @dataProvider gamestateProvider
     */
    public function testVerifyGamestate($variable, $exp)
    {
        $gamestate = $this->game->getGamestate();
        $this->assertEquals($gamestate[$variable], $exp);
    }

    /**
     * Dataprovider for gamestate verifier
     */
    public function gamestateProvider()
    {
        return [
            ["turnCounter", 0],
            ["turnIsOver", false],
            ["hasWon", null],
            ["currentPoints", 0]
        ];
    }


    /**
     * Test check hand with value six
     */
    public function testCheckHandWithValueSix()
    {
        // Run test with hand with value 6
        $this->diceHand->addToSerie(5);
        $this->diceHand->addToSerie(6);
        $this->game->checkHand($this->diceHand);
        $exp = 11;
        $res = $this->game->getGamestate()["currentPoints"];
        $this->assertEquals($exp, $res);
    }

    /**
     * Test check hand with value six
     */
    public function testCheckHandWithValueOne()
    {
        // Run test with hand with value 6
        $this->diceHand->addToSerie(1);
        $this->diceHand->addToSerie(2);
        $this->game->checkHand($this->diceHand);
        $exp = 0;
        $res = $this->game->getGamestate()["currentPoints"];
        $this->assertEquals($exp, $res);

        // Check that turn is over
        $res = $this->game->getGamestate()["turnIsOver"];
        $this->assertTrue($res);
    }

    /**
     * Test holding hand
     *
     */
    public function testHoldHand()
    {
        // Call checkhand with hand of 12 twice
        $this->diceHand->addToSerie(6);
        $this->diceHand->addToSerie(6);
        $this->game->checkHand($this->diceHand);
        $this->game->checkHand($this->diceHand);
        $this->game->holdHand();
        $gamestate = $this->game->getGamestate();

        $exp = 24;
        $res = $gamestate["active"]->getTotalPoints();
        $this->assertEquals($exp, $res);

        $res = $gamestate["turnIsOver"];
        $this->assertTrue($res);
    }

    /**
     * Test change player to computer
     * Assert false when called if active player is not computer
     */
    public function testComputerMove()
    {
        $this->assertFalse($this->game->computerMove(3));
        $this->game->startNextTurn();
        $this->assertTrue($this->game->computerMove(3));

        // Add points to currentPoints enough to pass treshhold
        // computerMove should return false
        $this->diceHand->addToSerie(6);
        $this->diceHand->addToSerie(6);
        $this->game->checkHand($this->diceHand);
        $this->game->checkHand($this->diceHand);
        $this->assertFalse($this->game->computerMove(3.5));
    }

    /**
     * Test resetting turnbased variables
     */
    public function testStartNextTurn()
    {
        $this->game->startNextTurn();
        $gamestate = $this->game->getGamestate();

        $exp = 1;
        $res = $gamestate["turnCounter"];
        $this->assertEquals($exp, $res);

        $exp = 0;
        $res = $gamestate["currentPoints"];
        $this->assertEquals($exp, $res);

        $exp = false;
        $res = $gamestate["turnIsOver"];
        $this->assertEquals($exp, $res);

        $exp = $this->game->getPlayer($gamestate["turnCounter"]);
        $res = $gamestate["active"];
        $this->assertEquals($exp, $res);

        $this->game->startNextTurn();
        $gamestate = $this->game->getGamestate();

        $exp = 0;
        $res = $gamestate["turnCounter"];
        $this->assertEquals($exp, $res);
    }

    /**
     * Test checking hasWon variable
     */
    public function testCheckWinner()
    {
        $gamestate = $this->game->getGamestate();
        $this->game->holdHand();
        $this->assertNull($gamestate["hasWon"]);

        $gamestate["active"]->addPoints(100);
        $exp = $gamestate["active"];
        $this->game->holdHand();

        $gamestate = $this->game->getGamestate();
        $this->assertEquals($exp, $gamestate["hasWon"]);
    }

    /**
     *
     */
    public function testResetPlayerPoints()
    {
        foreach ($this->game->getPlayers() as $player) {
            $player->addPoints(50);
            $exp = 50;
            $this->assertEquals($exp, $player->getTotalPoints());
        }

        $this->game->resetPlayers();
        foreach ($this->game->getPlayers() as $player) {-
            $exp = 0;
            $this->assertEquals($exp, $player->getTotalPoints());
        }
    }
}
