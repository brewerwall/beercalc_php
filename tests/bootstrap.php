<?php

/*
 * Bootstrap file for Beercalc
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');

require __DIR__ . "/../src/Beercalc/Beercalc.php";
