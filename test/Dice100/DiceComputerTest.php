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
        $arg1 = 0;
        $arg2 = 3;
        $move = $dicecomputer->calculateMove($arg1, $arg2);

        $this->assertTrue($move);
    }

    /**
     * Construct object and verify that calculateMove with 20 as argument
     * return false
     */
    public function testCalculateMoveArgumentEqualsTwenty()
    {
        $dicecomputer= new DiceComputer();
        $arg1 = 20;
        $arg2 = 3.5;
        $move = $dicecomputer->calculateMove($arg1, $arg2);

        $this->assertFalse($move);
    }

    /**
     * Construct object and verify that calculateMove  with 100 as argument
     * return false
     */
    public function testCalculateMoveArgumentEqualsOneHundred()
    {
        $dicecomputer= new DiceComputer();
        $arg1 = 100;
        $arg2 = 3;
        $move = $dicecomputer->calculateMove($arg1, $arg2);

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
        $arg1 = 1;
        $arg2 = 3;
        $move = $dicecomputer->calculateMove($arg1, $arg2);

        $this->assertFalse($move);
    }

    /**
     * Construct object, add points equal to upper threshold
     */
    public function testAddPointsCalculateMoveUpperThreshold()
    {
        $dicecomputer= new DiceComputer();
        $dicecomputer->addPoints(99);
        $arg1 = 32;
        $arg2 = 2;
        $move = $dicecomputer->calculateMove($arg1, $arg2);

        $this->assertFalse($move);
    }

    /**
     * Construct object, add 30 points and a low average roll score
     */
    public function testAddPointsCalculateMoveLowAverageRoll()
    {
        $dicecomputer= new DiceComputer();
        $dicecomputer->addPoints(99);
        $arg1 = 30;
        $arg2 = 2;
        $move = $dicecomputer->calculateMove($arg1, $arg2);

        $this->assertFalse($move);
    }

    /**
     * Construct object and get its type
     */
    public function testDiceComputerGetType()
    {
        $dicecomputer = new DiceComputer();
        $exp = "Computer";
        $res = $dicecomputer->getType();

        $this->assertEquals($exp, $res);
    }
}
