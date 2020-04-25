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
        $diceplayer = new DicePlayer();
        $this->assertInstanceOf("Nihl\Dice100\DicePlayer", $diceplayer);

        $exp = '/(Player)\d{4}/';
        $this->assertMatchesRegularExpression($exp, $diceplayer->getName());

        $exp = 0;
        $this->assertEquals($exp, $diceplayer->getTotalPoints());
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
        $diceplayer = new DicePlayer();

        $points = 10;
        $exp = 10;

        $diceplayer->addPoints($points);
        $this->assertEquals($exp, $diceplayer->getTotalPoints());

        $points = 100;
        $exp = 110;

        $diceplayer->addPoints($points);
        $this->assertEquals($exp, $diceplayer->getTotalPoints());
    }

    /**
     * Construct object, add points and check hasWon()
     */
    public function testDicePlayerHasWon()
    {
        $diceplayer = new DicePlayer();

        $points = 10;

        $diceplayer->addPoints($points);
        $this->assertFalse($diceplayer->hasWon());

        $points = 100;

        $diceplayer->addPoints($points);
        $this->assertTrue($diceplayer->hasWon());
    }

    /**
     * Construct object and get its type
     */
     public function testDicePlayerGetType()
     {
         $diceplayer = new DicePlayer();
         $exp = "Player";
         $res = $diceplayer->getType();

         $this->assertEquals($exp, $res);
     }

    /**
     *
     */
    public function testDicePlayerSetTotalPoints()
    {
        $diceplayer = new DicePlayer();

        $exp = -1;
        $diceplayer->setTotalPoints(-1);
        $this->assertEquals($exp, $diceplayer->getTotalPoints());

        $exp = 0;
        $diceplayer->setTotalPoints(0);
        $this->assertEquals($exp, $diceplayer->getTotalPoints());

        $exp = 20;
        $diceplayer->setTotalPoints(20);
        $this->assertEquals($exp, $diceplayer->getTotalPoints());

        $exp = 100;
        $diceplayer->setTotalPoints(100);
        $this->assertEquals($exp, $diceplayer->getTotalPoints());
    }
}
