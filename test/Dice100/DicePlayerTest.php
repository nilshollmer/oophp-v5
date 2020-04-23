<?php

namespace Nihl\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for dice player creation
 */
class DicePlayerTest extends TestCase
{


    /**
     * Construct objects with no argument and verify its properties
     */
    public function testCreateDicePlayersWithoutArgument()
    {
        $dicePlayer1 = new DicePlayer();
        $dicePlayer2 = new DicePlayer();
        $this->assertInstanceOf("Nihl\Dice100\DicePlayer", $dicePlayer1);

        $exp = "player1";
        $this->assertEquals($exp, $dicePlayer1->getName());

        $exp = "player2";
        $this->assertEquals($exp, $dicePlayer2->getName());

        $exp = 0;
        $this->assertEquals($exp, $dicePlayer1->getTotalPoints());
    }

    /**
     * Construct object with and without argument and verify its properties
     */
    public function testCreateDicePlayersWithAndWithoutArgument()
    {
        $nils = new DicePlayer("Nils");
        $dicePlayer4 = new DicePlayer("");

        $exp = "Nils";
        $this->assertEquals($exp, $nils->getName());

        $exp = "player4";
        $this->assertEquals($exp, $dicePlayer4->getName());
    }

    /**
     * Construct object, add points and verify properties
     */
    public function testDicePlayerAddPoints()
    {
        $dp = new DicePlayer();

        $points = 10;
        $exp = 10;

        $dp->addPoints($points);
        $this->assertEquals($exp, $dp->getTotalPoints());

        $points = 100;
        $exp = 110;

        $dp->addPoints($points);
        $this->assertEquals($exp, $dp->getTotalPoints());
    }

    /**
     * Construct object, add points and check hasWon()
     */
    public function testDicePlayerHasWon()
    {
        $dp = new DicePlayer();

        $points = 10;

        $dp->addPoints($points);
        $this->assertFalse($dp->hasWon());

        $points = 100;

        $dp->addPoints($points);
        $this->assertTrue($dp->hasWon());
    }
}
