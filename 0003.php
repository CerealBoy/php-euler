#!/usr/bin/env php
<?php
/**
 * Probably not the best solution for Problem 3.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$factors = array();
$large = 600851475143;

$possible = range(2,10000);

while (true) {
    $found = false;
    foreach ($possible as $number) {
        if (($large % $number) === 0) {
            $found = true;

            $factors[] = $number;
            $large /= $number;

            break;
        }
    }

    if (!$found) {
        break;
    }
}

sort($factors, SORT_NUMERIC);
$largest = array_pop($factors);

echo "The largest factor for {$large} is [{$largest}]\n\n";

