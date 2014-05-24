# Beercalc

Beercalc is a small helper class that holds various calculations to aid in designing your own beer recipes.  

## Installation

Create a `composer.json` file in your project root.
```json
{
    "require": {
        "brewerwall/beercalc_php": "dev-master"
    }
}
```
Install via composer:
```shell
php composer.phar install
```


## Methods

### Beercalc::abv($og, $fg)
Calculates an estimated alcohol by volume estimate based on the original gravity (og) of the wort and final gravity (fg) of the produced beer.

* og   : number - original gravity
* fg   : number - final gravity

```php
Beercalc::abv(1.055, 1);
=> 7.204999999999992
```

### Beercalc::abw($og, $fg)
Calculates an estimated alcohol by weight estimate based on the original gravity (og) of the wort and final gravity (fg) of the produced beer.

* og   : number - original gravity
* fg   : number - final gravity

```php
Beercalc::abv(1.055, 1);
=> 5.691949999999994
```

### Beercalc::mcu($weight, $lovibond, $volume)
Calculates the Malt Color Unit of your recipe.

* weight   : number - lbs of grain
* lovibond : number - lovibond value of the grain
* volume   : number - gallons

```php
Beercalc::mcu(5, 5, 5);
=> 5
```


### Beercalc::srm($weight, $lovibond, $volume)
Provides a more accurate color rating of your recipe using the Morey equation.

* weight   : number - lbs of grain
* lovibond : number - lovibond value of the grain
* volume   : number - gallons

```php
Beercalc::srm(7,5,5);
=> 5.668651803424155
```


### Beercalc::aau($alpha, $weight)
Calculates the Alpha Acid Units in hops.

* weight   : number - oz of hops
* alpha    : number - Alpha percentage of the hops

```php
Beercalc::aau(1, 4.6);
=> 4.6
```


### Beercalc::ibu($alpha, $weight, $time, $gravity, $volume)
Calculates the International Bittering Units scale.  This is calculated per hop addition and needs.  The sum of each hop addition is the total IBU for recipe.

* alpha    : number - Alpha percentage of the hops
* weight   : number - oz of hops
* time     : number - minutes hops are in the boil
* gravity  : number - gravity of the wort at the time of addition
* volume   : number - volume of the recipe.

In the below example we have two hop additions.  Each giving the IBU value for the respective addition.  The total IBU for the recipe would be the summation of these two additions.

```php
Beercalc::ibu(6.4, 1.5, 60, 1.080, 5);
=> 25.365869680614512
Beercalc::ibu(4.6, 1, 15, 1.080, 5);
=> 6.03108750923272
```

So the total IBU for the recipe is 25.365869680614512 + 6.03108750923272 = 31.39695718984723


### Beercalc::plato($sGravity)
Based on the specific gracity, determines the value in Plato.

* sGravity   : number - specific gravity

```php
Beercalc::plato(1.070);
=> 17.055185000000108
```

### Beercalc::realExtract($og, $fg)
Determines the real extract based on measured original and final gravity

* og   : number - original gravity
* fg	 : number - final gravity

```php
Beercalc::realExtract(1.070, 1.015);
=> 6.216277095999994
```

### Beercalc::calories($og, $fg)
Determines the approximate calories that would be in a 12oz volume

* og   : number - original gravity
* fg	 : number - final gravity

```php
Beercalc::calories(1.070, 1.015);
=> 227.57821703464833
```

### Beercalc::attenuation($og, $fg)
Calculates the percentage of attenuation from fermentation.  Assuming og and fg are entered as 1.054 and not in Gravity Unit form.

* og   : number - original gravity
* fg	 : number - final gravity

```php
Beercalc::attenuation(1.054, 1.012);
=> 0.7777777777777778
```

### Beercalc::gu($g)
Converts standard gravity measure (Ex. 1.054) to gravity units (Ex. 54) aka GU.

* g   : number - gravity

```php
Beercalc::gu(1.054);
=> 54
```

### Beercalc::totalGravity($g, $v)
The product of wort volume by the measured gravity.

* g   : number - gravity
* v   : number - volume in gallons

```php
Beercalc::totalGravity(1.054, 5);
=> 270
```

### Beercalc::finalGravity($g, $vol_beg, $vol_end)
The projected gravity of the final wort based on final volume. Returns in gravity units.

* g   			: number - gravity
* vol_beg   : number - volume in gallons at the begining of the boil
* vol_end		: number - volume in gallons at the end of the boil

```php
Beercalc::finalGravity(1.054, 5, 5);
=> 54
```

### Beercalc::extractAddition($target_gu, $total_gu, $extractType)
In the even your mash does not produce a high enough gravity, you can add extract to reach your desired gravity.  This method will let you add your target gravity, your total gravity from the mash and what kind of extract you would like to use.  Return value will be the amount of extract in pounds that would need to be added in the boil.

* target_gu   	: number - Target Total Gravity in Gravity Units
* total_gu   		: number - Mash Total Gravity in Gravity Units
* extractType		: string/number - should be 'LME' or 'DME' or custom value

```php
Beercalc::extractAddition(408, 355, 'DME');
=> 1.1777777777777778
```

### Beercalc::gravityCorrection($temp, $g)
Corrects the gravity reading based on the temperature of the sample.

* temp 			: number - temperature in Fahrenheit
* g   			: number - gravity

```php
Beercalc::gravityCorrection(100.4, 1.050);
=> 1.0560765751842796
```
