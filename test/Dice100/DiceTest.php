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
        $roll = $dice->roll();

        $this->assertGreaterThanOrEqual($min, $roll);
        $this->assertLessThanOrEqual($max, $roll);
    }


    /**
     * Construct object, roll dice and verify that graphic outputs string in
     * the following format: "dice-*"
     */
    public function testDiceGraphic()
    {
        $dice = new Dice();
        $roll = $dice->roll();
        $res = $dice->graphic();
        $exp = "dice-" . $roll;

        $this->assertEquals($exp, $res);
    }
}
