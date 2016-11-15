<?php

namespace Beercalc;

class Beercalc{

  /* ABV()
  #  param og: number - original gravity
  #  param fg: number - final gravity
  */
  public static function abv($og, $fg){
    if($og > $fg && is_numeric($og) && is_numeric($fg))
      return (76.08 * ($og - $fg) / (1.775 - $og)) * ($fg / 0.794);
    else
      return null;
  }

  /* ABW()
  #  param og: number - original gravity
  #  param fg: number - final gravity
  #  SOURCE = http://hbd.org/ensmingr/
  */
  public static function abw($og, $fg){
    if($og > $fg && is_numeric($og) && is_numeric($fg))
      return (0.79 * self::abv($og, $fg)) / $fg;
    else
      return null;
  }

  /* MCU()
  #  param weight: number - lbs of grain
  #  param lovibond: number - typically a number between
  #  param volume: number - gallons
  */
  public static function mcu($weight, $lovibond, $volume){
    if($volume != 0 && is_numeric($weight) && is_numeric($lovibond) && is_numeric($volume))
      return ($weight * $lovibond) / $volume;
    else
      return null;
  }

  /* SRM()
  #  param weight: number - lbs of grain
  #  param lovibond: number - typically a number between 1-25
  #  param volume: number - gallons
  */
  public static function srm($weight, $lovibond, $volume){
    if(is_numeric($weight) && is_numeric($lovibond) && is_numeric($volume))
      return 1.4922 * (pow(self::mcu($weight, $lovibond, $volume), 0.6859));
    else
      return null;
  }

  /* AAU()
  #  param alpha: percent - alpha unit of the hop
  #  param weight: number - oz of hops
  */
  public static function aau($alpha, $weight){
    if(is_numeric($alpha) && is_numeric($weight))
      return $alpha * $weight;
    else
      return null;
  }

  /* IBU()
  #  param alpha: percent - alpha unit of the hop
  #  param weight: number - oz of hops
  #  param utilization: number - output of self.utilization
  #  param volume: number - gallons
  */
  public static function ibu($alpha, $weight, $time, $gravity, $volume){
    if($volume != 0 && is_numeric($alpha) && is_numeric($weight) && is_numeric($time) && is_numeric($gravity) && is_numeric($volume))
      return self::aau($alpha, $weight) * self::utilization($time, $gravity) * 75 / $volume;
    else
      return null;
  }

  /* UTILIZATION()
  #  param time: number - minute hops are in the boil
  #  param gravity: number - gravity of the boil upon inserting Ex. 1.050
  */
  public static function utilization($time, $gravity){
    if(is_numeric($time) && is_numeric($gravity))
      return (1.65 * pow(0.000125,($gravity - 1))) * (1 - pow(M_E,(-0.04 * $time))) / 4.15;
    else
      return null;
  }

  /* PLATO
  #  param sGravity: number - specific gravity
  #  SOURCE = http://hbd.org/ensmingr/
  */
  public static function plato($sGravity){
    if(is_numeric($sGravity))
      return (-463.37) + (668.72 * $sGravity) - (205.35 * pow($sGravity,2));
    else
      return null;
  }

  /* REAL EXTRACT
  #  param og: number - original gravity
  #  param fg: number - final gracivity
  #  SOURCE = http://hbd.org/ensmingr/
  */
  public static function realExtract($og, $fg){
    if($og > $fg && is_numeric($og) && is_numeric($fg))
      return(0.1808 * self::plato($og)) + (0.8192 * self::plato($fg));
    else
      return null;
  }

  /* CALORIES (in 12 ounce increments)
  #  param og: number - original gravity
  #  param fg: number - final gravity
  #  SOURCE = http://hbd.org/ensmingr/
  */
  public static function calories($og, $fg){
    if($og > $fg && is_numeric($og) && is_numeric($fg))
      return ((6.9 * self::abw($og, $fg)) + 4.0 * (self::realExtract($og, $fg) - 0.1)) * $fg * 3.55;
    else
      return null;
  }

  /* ATTENUATION
  #  param og: number - original gravity
  #  param fg: number - final gracivity
  #  Assuming this is in gravity (Ex. 1.054)
  */
  public static function attenuation($og, $fg){
    if($og > $fg && is_numeric($og) && is_numeric($fg))
      return ($og - $fg)/($og - 1);
    else
      return null;
  }

  /* GRAVITY UNITS
  #  param g: number - gravity
  */
  public static function gu($g){
    if(is_numeric($g))
      return round(($g - 1) * 1000);
    else
      return null;
  }

  /* TOTAL GRAVITY
  # param g: number - gravity
  # param vol: number - volume in gallons
  */
  public static function totalGravity($g, $v){
    if(is_numeric($g) && is_numeric($v))
      return self::gu($g) * $v;
    else
      return null;
  }

  /* FINAL GRAVITY
  #  param g: number - initial gravity
  #  param vol_beg: number - volume in gallons at the begining of the boil
  #  param vol_end: number - volume in gallons at the end of the boil
  */
  public static function finalGravity($g, $vol_beg, $vol_end){
    if(is_numeric($g) && is_numeric($vol_beg) && is_numeric($vol_end))
      return self::totalGravity($g, $vol_beg) / $vol_end;
    else
      return null;
  }

  /* EXTRACT ADDITION
  # param target_gu: number - Target Total Gravity in Gravity Units
  # param total_gu: number - Total Gravity from Mash in Gravity Units
  # param extract: string/number - should be 'LME' or 'DME' or custom value
  */
  public static function extractAddition($target_gu, $total_gu, $extractType){
    if($extractType == 'LME')
      $extract = 38;
    elseif($extractType == 'DME')
      $extract = 45;
    elseif(is_numeric($extractType))
      $extract = $extractType;

    if(is_numeric($target_gu) && is_numeric($total_gu) && is_numeric($extract))
      return ($target_gu - $total_gu) / $extract;
    else
      return null;
  }

  /* GRAVITY TEMPERATURE CORRECTION
  # param temp: number - Temperature in Fahrenheit
  # param g: number - Gravity from the hydrometer reading
  */
  public static function gravityCorrection($temp, $g){
    if(is_numeric($temp) && is_numeric($g))
      return ((1.313454 - 0.132674*$temp + 2.057793*pow(10,-3)*pow($temp,2) - 2.627634*pow(10,-6)*pow($temp,3)) * 0.001) + $g;
    else
      return null;
  }
}
