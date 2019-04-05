<?php

namespace Brewerwall;

final class Beercalc
{
    /**
     * Determines the Alcohol By Volume (ABV)
     *
     * @param float $originalGravity
     * @param float $finalGravity
     * @return float|null
     */
    public static function abv(float $originalGravity, float $finalGravity): ?float
    {
        if($originalGravity > $finalGravity){
            return (76.08 * ($originalGravity - $finalGravity) / (1.775 - $originalGravity)) * ($finalGravity / 0.794);
        }

        return null;
    }

    /**
     * Determines Alcohol By Weight (ABW)
     *
     * @param float $originalGravity
     * @param float $finalGravity
     * @return float|null
     */
    public static function abw(float $originalGravity, float $finalGravity): ?float
    {
        if($originalGravity > $finalGravity){
            return (0.79 * self::abv($originalGravity, $finalGravity)) / $finalGravity;
        }

        return null;
    }

    /**
     * Determines Malt Color Unit (MCU)
     *
     * @param float $pounds
     * @param float $lovibond
     * @param float $gallons
     * @return float|null
     */
    public static function mcu(float $pounds, float $lovibond, float $gallons): ?float
    {
        if($gallons > 0 || $gallons < 0){
            return ($pounds * $lovibond) / $gallons;
        }

        return null;
    }

    /**
     * Determines Standard Reference Method (SRM)
     *
     * @param float $pounds
     * @param float $lovibond
     * @param float $gallons
     * @return float|null
     */
    public static function srm(float $pounds, float $lovibond, float $gallons): ?float
    {
        return 1.4922 * (pow(self::mcu($pounds, $lovibond, $gallons), 0.6859));
    }

    /**
     * Determines Alpha Acid Unit (AAU)
     *
     * @param float $alphaAcid
     * @param float $ounces
     * @return void
     */
    public static function aau(float $alphaAcid, float $ounces): float
    {
        return $alphaAcid * $ounces;
    }

    /**
     * Determines Hop Utilization
     *
     * @param float $minutes
     * @param float $specificGravity
     * @return float
     */
    public static function utilization(float $minutes, float $specificGravity): float
    {
        return (1.65 * pow(0.000125,($specificGravity - 1))) * (1 - pow(M_E,(-0.04 * $minutes))) / 4.15;
    }

    /**
     * Determines Internation Bittering Units (IBU)
     *
     * @param float $alphaAcid
     * @param float $ounces
     * @param float $minutes
     * @param float $specificGravity
     * @param float $gallons
     * @return float|null
     */
    public static function ibu(float $alphaAcid, float $ounces, float $minutes, float $specificGravity, float $gallons): ?float
    {
        if($gallons > 0 || $gallons < 0){
            return self::aau($alphaAcid, $ounces) * self::utilization($minutes, $specificGravity) * 75 / $gallons;
        }

        return null;
    }

    /**
     * Convert Specific Gravity to Plato http://hbd.org/ensmingr/
     *
     * @param float $specificGravity
     * @return float
     */
    public static function convertToPlato(float $specificGravity): float
    {
        return (-463.37) + (668.72 * $specificGravity) - (205.35 * pow($specificGravity,2));
    }

    /**
     * Determine the Real Extract value.
     * http://hbd.org/ensmingr/
     *
     * @param float $originalGravity
     * @param float $finalGravity
     * @return void
     */
    public static function realExtract(float $originalGravity, float $finalGravity)
    {
        if($originalGravity > $finalGravity){
            return(0.1808 * self::convertToPlato($originalGravity)) + (0.8192 * self::convertToPlato($finalGravity));
        }

        return null;
    }

    /**
     * Determine Calories per 12oz Serving
     *
     * @param float $originalGravity
     * @param float $finalGravity
     * @return float|null
     */
    public static function calories(float $originalGravity, float $finalGravity): ?float
    {
        if($originalGravity > $finalGravity){
            return ((6.9 * self::abw($originalGravity, $finalGravity)) + 4.0 * (self::realExtract($originalGravity, $finalGravity) - 0.1)) * $finalGravity * 3.55;
        }

        return null;
    }

    /**
     * Determines Attenuation
     *
     * @param float $originalGravity
     * @param float $finalGravity
     * @return float|null
     */
    public static function attenuation(float $originalGravity, float $finalGravity): ?float
    {
        if($originalGravity > $finalGravity){
            return ($originalGravity - $finalGravity)/($originalGravity - 1);
        }

        return null;
    }

    /**
     * Determines Gravity Temperature Correction
     *
     * @param float $fahrenheit
     * @param float $specificGravity
     * @param float $calibrationFahrenheit
     * @return float
     */
    public static function gravityCorrection(float $fahrenheit, float $specificGravity, float $calibrationFahrenheit): float
    {
        return $specificGravity * ((1.00130346 - 0.000134722124 * $fahrenheit + 0.00000204052596 * pow($fahrenheit, 2) - 0.00000000232820948 * pow($fahrenheit, 3)) / (1.00130346 - 0.000134722124 * $calibrationFahrenheit + 0.00000204052596 * pow($calibrationFahrenheit, 2) - 0.00000000232820948 * pow($calibrationFahrenheit, 3)));
    }
}
