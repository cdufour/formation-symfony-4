<?php
namespace App\Test\Service;

use App\Service\CalculatorService;
use PHPUnit\Framework\TestCase;

class CalculatorServiceTest extends TestCase
{
    public function testSquare()
    {
        $calculator = new CalculatorService();
        $result = $calculator->square(5);
        $result2 = $calculator->square(8);

        // assertion
        $this->assertEquals(25, $result);
        $this->assertEquals(64, $result2);
    }

    public function testCube()
    {
        $calculator = new CalculatorService();
        $result = $calculator->cube(2);
 
        // assertion
        $this->assertEquals(8, $result);
    }

    public function testTva()
    {
        $calculator = new CalculatorService();
        $result = $calculator->tva(18.3); // prix HT: 18.3 + tva: 3.66
        //3.66
        // assertion
        $this->assertEquals(21.96, $result); // prix TTC 21.96
    }
}