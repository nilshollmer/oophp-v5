<?php

namespace Nihl\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for dice computer creation
 */
class DiceComputerTest extends TestCase
{


    /**
     * Construct object and verify its properties
     */
    public function testCreateDiceComputer()
    {
        $dicecomputer= new DiceComputer();
        $this->assertInstanceOf("Nihl\Dice100\DiceComputer", $dicecomputer);

        $exp = '/(Computer)\d{4}/';
        $this->assertMatchesRegularExpression($exp, $dicecomputer->getName());

        $exp = 0;
        $this->assertEquals($exp, $dicecomputer->getTotalPoints());
    }

    /**
     * Construct object and verify that calculateMove with 0 as argument
     * return true
     */
    public function testCalculateMoveArgumentEqualsZero()
    {
        $dicecomputer= new DiceComputer();
        $arg = 0;
        $move = $dicecomputer->calculateMove($arg);

        $this->assertTrue($move);
    }

    /**
     * Construct object and verify that calculateMove with 20 as argument
     * return false
     */
    public function testCalculateMoveArgumentEqualsTwenty()
    {
        $dicecomputer= new DiceComputer();
        $arg = 20;
        $move = $dicecomputer->calculateMove($arg);

        $this->assertFalse($move);
    }

    /**
     * Construct object and verify that calculateMove  with 100 as argument
     * return false
     */
    public function testCalculateMoveArgumentEqualsOneHundred()
    {
        $dicecomputer= new DiceComputer();
        $arg = 100;
        $move = $dicecomputer->calculateMove($arg);

        $this->assertFalse($move);
    }

    /**
     * Construct object, add 99 points and verify that calculateMove with 1 as argument
     * return false
     */
    public function testAddPointsCalculateMoveArgumentEqualsOne()
    {
        $dicecomputer= new DiceComputer();
        $dicecomputer->addPoints(99);
        $arg = 1;
        $move = $dicecomputer->calculateMove($arg);

        $this->assertFalse($move);
    }
}
