<?php

namespace Nihl\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for dice hand creation, rolling a number of dice, printing
 * hand as strings and printing sum of hand
 */
class DiceHandTest extends TestCase
{
    /**
     * Construct object and verify instance of object
     */
    public function testCreateDiceHand()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("Nihl\Dice100\DiceHand", $diceHand);
    }

    /**
     * Construct object with no argument and verify
     * that the right amount of dice have been rolled
     */
    public function testDiceHandRollWithNoArgument()
    {
        $diceHand = new DiceHand();
        $diceHand->rollDice();
        $exp = 2;

        $this->assertEquals($exp, count($diceHand->getHandValues()));
    }

    /**
     * Construct object with argument and verify
     * that the right amount of dice have been rolled
     */
    public function testDiceHandRollWithArgument()
    {
        $diceHand = new DiceHand(6);
        $diceHand->rollDice();
        $exp = 6;

        $this->assertEquals($exp, count($diceHand->getHandValues()));
    }

    /**
     * Construct object with argument and verify that the sum of 4 dice are
     * between 4 and 24
     */
    public function testDiceHandSum()
    {
        $numDice = 4;
        $min = 4;
        $max = 24;

        $diceHand = new DiceHand($numDice);
        $diceHand->rollDice();

        $this->assertGreaterThanOrEqual($min, $diceHand->sumOfHand());
        $this->assertLessThanOrEqual($max, $diceHand->sumOfHand());
    }

    /**
     * Construct object with argument and verify that handValues is an
     * array of numbers
     */
    public function testDiceHandValues()
    {
        $numDice = 20;

        $diceHand = new DiceHand($numDice);
        $diceHand->rollDice();

        foreach ($diceHand->getHandValues() as $res) {
            $this->assertIsNumeric($res);
        }
    }

    /**
     * Construct object with argument and verify that handContainsOne()
     * returns true if $handValues contains a value of
     */
    public function testDiceHandContainsOneTrue()
    {
        $numDice = 1;

        $diceHand = new DiceHand($numDice);
        $diceHand->addToHandValues(1);
        
        $this->assertTrue($diceHand->handContainsOne());
    }

    /**
     * Construct object with argument and verify that handContainsOne()
     * returns false
     */
    public function testDiceHandContainsOneFalse()
    {
        $numDice = 1;

        $diceHand = new DiceHand($numDice);
        $diceHand->addToHandValues(4);

        $this->assertFalse($diceHand->handContainsOne());
    }
}
