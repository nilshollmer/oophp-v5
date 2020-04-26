<?php

namespace Nihl\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for dice creation, dice roll and graphic output
 */
class DiceTest extends TestCase
{
    /**
     * Construct object and verify instance of object
     */
    public function testCreateDice()
    {
        $dice = new Dice();
        $this->assertInstanceOf("Nihl\Dice100\Dice", $dice);
    }


    /**
     * Construct object and verify that value of roll is integer between 1-6
     */
    public function testDiceRoll()
    {
        $min = 1;
        $max = 6;

        $dice = new Dice();
        $dice->roll();
        $roll = $dice->getLastRoll();

        $this->assertGreaterThanOrEqual($min, $roll);
        $this->assertLessThanOrEqual($max, $roll);
    }
}
