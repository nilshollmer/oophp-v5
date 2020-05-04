<?php

namespace Nihl\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for Histogram
 */

class HistogramTest extends TestCase
{
    /**
     * Test create Histogram and verify instance of object
     */
    public function testCreateHistogram()
    {
        $histogram = new Histogram();
        $this->assertInstanceOf("Nihl\Dice100\Histogram", $histogram);
    }


    /**
     * Test create Histogram, inject dicehand and get serie
     */
    public function testHistogramInjectDataAndGetSerie()
    {
        $histogram = new Histogram();
        $diceHand = new DiceHand(2);
        $diceHand->addToSerie(6);
        $diceHand->addToSerie(2);

        $histogram->injectData($diceHand);

        $res = $histogram->getSerie();
        $this->assertIsArray($res);

        $exp = 6;
        $this->assertEquals($exp, $res[0][0]);

        $exp = 2;
        $this->assertEquals($exp, $res[0][1]);
    }

    /**
     * Test create Histogram, inject dicehand and get averageRoll
     */
    public function testHistogramGetAverageRollNoRolls()
    {
        $histogram = new Histogram();

        $exp = 0;
        $res = $histogram->getAverageRoll();
        $this->assertEquals($exp, $res);
    }

    /**
     * Test create Histogram, inject dicehand and get averageRoll
     */
    public function testHistogramGetAverageRoll()
    {
        $histogram = new Histogram();
        $diceHand = new DiceHand(2);

        $diceHand->addToSerie(6);
        $diceHand->addToSerie(2);
        $histogram->injectData($diceHand);

        $res = $histogram->getAverageRoll();
        $exp = 4;
        $this->assertEquals($exp, $res);
    }

    /**
     * Test create Histogram, inject dicehand
     */
    public function testHistogramGetStatistics()
    {
        $histogram = new Histogram();
        $diceHand = new DiceHand(2);
        $diceHand->rollDice();

        $histogram->injectData($diceHand);

        $res = $histogram->getStatistics();
        $this->assertIsString($res);
    }

    /**
     * Test create Histogram, inject dicehand and get individual rolls
     */
    public function testHistogramGetIndividualRolls()
    {
        $histogram = new Histogram();
        $diceHand = new DiceHand(2);
        $diceHand->rollDice();

        $histogram->injectData($diceHand);

        $res = $histogram->getIndividualRolls();
        $this->assertIsString($res);
    }
}
