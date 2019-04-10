<?php

namespace Tests\Unit;

use Brewerwall\Beercalc;
use PHPUnit\Framework\TestCase;

class BeercalcTest extends TestCase
{
    /** @var Beercalc */
    private $beercalc;

    public function setUp(): void
    {
        $this->beercalc = new Beercalc();
    }

    public function testABV()
    {
        $this->assertEquals(7.319479429051208, $this->beercalc->abv(1.055, 1));
        $this->assertEquals(null, $this->beercalc->abv(1, 1.055));
    }

    public function testABW()
    {
        $this->assertEquals(5.782388748950455, $this->beercalc->abw(1.055, 1));
        $this->assertEquals(null, $this->beercalc->abw(1, 1.055));
    }

    public function testMCU()
    {
        $this->assertEquals(null, $this->beercalc->mcu(1, 1, 0));
        $this->assertEquals(5, $this->beercalc->mcu(5, 5, 5));
        $this->assertEquals(5.5, $this->beercalc->mcu(5.5, 5.5, 5.5));
    }

    public function testSRM()
    {
        $this->assertEquals(null, $this->beercalc->srm(7, 5, 0));
        $this->assertEquals(5.668651803424155, $this->beercalc->srm(7, 5, 5));
        $this->assertEquals(5.943353419684101, $this->beercalc->srm(7.5, 5.5, 5.5));
    }

    public function testAAU()
    {
        $this->assertEquals(9.600000000000001, $this->beercalc->aau(1.5, 6.4));  // Based off Palmer's Calculation
        $this->assertEquals(4.6, $this->beercalc->aau(1, 4.6));  // Based off Palmer's Calculation
    }

    public function testUtilization()
    {
        $this->assertEquals(0.08363227080582435, $this->beercalc->utilization(10, 1.050));
        $this->assertEquals(0.30113013986478654, $this->beercalc->utilization(120, 1.030));
        $this->assertEquals(0.0, $this->beercalc->utilization(0, 1.070));
        $this->assertEquals(0.14780486892282785, $this->beercalc->utilization(45, 1.090));
    }

    public function testIBU()
    {
        $this->assertEquals(25.365869680614512, $this->beercalc->ibu(6.4, 1.5, 60, 1.080, 5)); //Based off Palmer's Calculation
        $this->assertEquals(6.03108750923272, $this->beercalc->ibu(4.6, 1, 15, 1.080, 5)); //Based off Palmer's Calculation
    }

    public function testPlato()
    {
        $this->assertEquals(17.055185000000108, $this->beercalc->convertToPlato(1.070));
    }

    public function testRealExtract()
    {
        $this->assertEquals(6.216277095999994, $this->beercalc->realExtract(1.070, 1.015));
        $this->assertEquals(null, $this->beercalc->realExtract(1.015, 1.070));
    }

    public function testCalories()
    {
        $this->assertEquals(234.97692128247783, $this->beercalc->calories(1.070, 1.015));  // Based on http://hbd.org/ensmingr/
        $this->assertEquals(null, $this->beercalc->calories(1.015, 1.070));
    }

    public function testAttenuation()
    {
        $this->assertEquals(0.7777777777777778, $this->beercalc->attenuation(1.054, 1.012));
        $this->assertEquals(null, $this->beercalc->attenuation(1, 1.055));
    }

    public function testGravityCorrection()
    {
        $this->assertEquals(1.0562227410997, $this->beercalc->gravityCorrection(100.4, 1.050, 60));
    }
}
