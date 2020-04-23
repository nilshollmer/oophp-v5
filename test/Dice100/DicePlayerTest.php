<?php

namespace Nihl\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for dice player creation
 */
class DicePlayerTest extends TestCase
{
    /**
     * Construct object with no argument and verify its properties
     */
    public function testCreateDicePlayerWithoutArgument()
    {
        $dp = new DicePlayer();
        $this->assertInstanceOf("Nihl\Dice100\DicePlayer", $dp);

        $exp = '/(Player)\d{4}/';
        $this->assertMatchesRegularExpression($exp, $dp->getName());

        $exp = 0;
        $this->assertEquals($exp, $dp->getTotalPoints());
    }

    /**
     * Construct object with argument and verify its properties
     */
    public function testCreateDicePlayerWithArgument()
    {
        $nils = new DicePlayer("Nils");

        $exp = "Nils";
        $this->assertEquals($exp, $nils->getName());
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
