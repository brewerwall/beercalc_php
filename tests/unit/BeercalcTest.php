<?php

namespace Beercalc;

class BeercalcTest extends \PHPUnit_Framework_TestCase {

  public function testABV(){
    $this->assertEquals(7.204999999999992, Beercalc::abv(1.055, 1));
    $this->assertEquals(null, Beercalc::abv(1, 1.055));
    $this->assertEquals(null, Beercalc::abv("asdf", "asdf"));
  }

  public function testABW(){
    $this->assertEquals(5.691949999999994, Beercalc::abw(1.055, 1));
    $this->assertEquals(null, Beercalc::abw(1, 1.055));
    $this->assertEquals(null, Beercalc::abw("asdf", "asdf"));
  }

  public function testMCU(){
    $this->assertEquals(null, Beercalc::mcu(1, 1, 0));
    $this->assertEquals(null, Beercalc::mcu(1, 1, null));
    $this->assertEquals(null, Beercalc::mcu(null, 1, 1));
    $this->assertEquals(null, Beercalc::mcu(1, null, 1));
    $this->assertEquals(null, Beercalc::mcu(null, null, null));
    $this->assertEquals(5, Beercalc::mcu(5, 5, 5));
    $this->assertEquals(5.5, Beercalc::mcu(5.5, 5.5, 5.5));
  }

  public function testSRM(){
    $this->assertEquals(null, Beercalc::srm(null, null, null));
    $this->assertEquals(null, Beercalc::srm("asdf", null, "asdf"));
    $this->assertEquals(5.668651803424155, Beercalc::srm(7, 5, 5));
    $this->assertEquals(5.943353419684101, Beercalc::srm(7.5, 5.5, 5.5));
  }

  public function testAAU(){
    $this->assertEquals(null, Beercalc::aau(null, 5));
    $this->assertEquals(null, Beercalc::aau(4, null));
    $this->assertEquals(null, Beercalc::aau(null, null));
    $this->assertEquals(null, Beercalc::aau("asdf", "asdf"));
    $this->assertEquals(9.600000000000001, Beercalc::aau(1.5, 6.4));  // Based off Palmer's Calculation
    $this->assertEquals(4.6, Beercalc::aau(1, 4.6));  // Based off Palmer's Calculation
  }

  public function testUtilization(){
    $this->assertEquals(0.08363227080582435, Beercalc::utilization(10, 1.050));
    $this->assertEquals(0.30113013986478654, Beercalc::utilization(120, 1.030));
    $this->assertEquals(0.0, Beercalc::utilization(0, 1.070));
    $this->assertEquals(0.14780486892282785, Beercalc::utilization(45, 1.090));
    $this->assertEquals(null, Beercalc::utilization(null, null));
  }

  public function testIBU(){
    $this->assertEquals(25.365869680614512, Beercalc::ibu(6.4, 1.5, 60, 1.080, 5)); //Based off Palmer's Calculation
    $this->assertEquals(6.03108750923272, Beercalc::ibu(4.6, 1, 15, 1.080, 5)); //Based off Palmer's Calculation
    $this->assertEquals(null, Beercalc::ibu(null, 1, 15, 1.080, 5));
    $this->assertEquals(null, Beercalc::ibu(null, null, 15, 1.080, 5));
    $this->assertEquals(null, Beercalc::ibu(null, null, null, 1.080, 5));
    $this->assertEquals(null, Beercalc::ibu(null, null, null, null, 5));
    $this->assertEquals(null, Beercalc::ibu(null, null, null, 1.080, null));
    $this->assertEquals(null, Beercalc::ibu(4.6, 1, 15, 1.080, "asdf"));
  }

  public function testPlato(){
    $this->assertEquals(17.055185000000108, Beercalc::plato(1.070));  // Based on http://hbd.org/ensmingr/
    $this->assertEquals(null, Beercalc::plato(null));
    $this->assertEquals(null, Beercalc::plato("asdf"));
  }

  public function testRealExtract(){
    $this->assertEquals(6.216277095999994, Beercalc::realExtract(1.070, 1.015));  // Based on http://hbd.org/ensmingr/
    $this->assertEquals(null, Beercalc::realExtract(1.015, 1.070));
    $this->assertEquals(null, Beercalc::realExtract(null, null));
    $this->assertEquals(null, Beercalc::realExtract("asdf", "asdf"));
  }

  public function testCalories(){
    $this->assertEquals(227.57821703464833, Beercalc::calories(1.070, 1.015));  // Based on http://hbd.org/ensmingr/
    $this->assertEquals(null, Beercalc::calories(1.015, 1.070));
    $this->assertEquals(null, Beercalc::calories(null, null));
    $this->assertEquals(null, Beercalc::calories("asdf", "asdf"));
  }

  public function testAttenuation(){
    $this->assertEquals(0.7777777777777778, Beercalc::attenuation(1.054, 1.012));
    $this->assertEquals(null, Beercalc::attenuation(1, 1.055));
    $this->assertEquals(null, Beercalc::attenuation("asdf", "asdf"));
    $this->assertEquals(null, Beercalc::attenuation(null, null));
  }

  public function testGravityUnits(){
    $this->assertEquals(54, Beercalc::gu(1.054));
    $this->assertEquals(null, Beercalc::gu("asdf"));
    $this->assertEquals(null, Beercalc::gu(null));
  }

  public function testTotalGravity(){
    $this->assertEquals(270, Beercalc::totalGravity(1.054, 5));
    $this->assertEquals(null, Beercalc::totalGravity("asdf", "asdf"));
    $this->assertEquals(null, Beercalc::totalGravity(null, null));
  }

  public function testFinalGravity(){
    $this->assertEquals(54, Beercalc::finalGravity(1.054, 5, 5));
    $this->assertEquals(null, Beercalc::finalGravity("asdf", "asdf", "asdf"));
    $this->assertEquals(null, Beercalc::finalGravity(null, null, null));
  }

  public function testExtractAddition(){
    $this->assertEquals(1.1777777777777778, Beercalc::extractAddition(408, 355, 45));
    $this->assertEquals(1.1777777777777778, Beercalc::extractAddition(408, 355, 'DME'));
    $this->assertEquals(1.394736842105263, Beercalc::extractAddition(408, 355, 'LME'));
    $this->assertEquals(null, Beercalc::extractAddition("asdf", "asdf", 'LME'));
    $this->assertEquals(null, Beercalc::extractAddition("asdf", "asdf", 'asdf'));
  }

  public function testGravityCorrection(){
    $this->assertEquals(1.0562227410997, Beercalc::gravityCorrection(100.4, 1.050, 60));
    $this->assertEquals(null, Beercalc::gravityCorrection(100.4, "asdf", 60));
    $this->assertEquals(null, Beercalc::gravityCorrection("asdf", 1.050, 60));
    $this->assertEquals(null, Beercalc::gravityCorrection("asdf", "asdf", 60));
    $this->assertEquals(null, Beercalc::gravityCorrection("asdf", 1.050, "asdf"));
    $this->assertEquals(null, Beercalc::gravityCorrection(100.4, 1.050, "asdf"));
    $this->assertEquals(null, Beercalc::gravityCorrection("asdf", "asdf", "asdf"));
  }
}
