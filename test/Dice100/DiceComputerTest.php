<?php

namespace Nihl\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for dice computer creation
 */
class DiceComputerTest extends TestCase
{


    /**
     * Construct objects with no argument and verify its properties
     */
    public function testCreateDiceComputer()
    {
        $dc= new DiceComputer();
        $this->assertInstanceOf("Nihl\Dice100\DiceComputer", $dc);

        $exp = '/(Computer)\d{4}/';
        $this->assertMatchesRegularExpression($exp, $dc->getName());

        $exp = 0;
        $this->assertEquals($exp, $dc->getTotalPoints());
    }

}
