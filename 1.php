#!/usr/bin/env php
<?php
/**
 * Rough and hacky script for Problem 1.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$total = 0;
foreach (range(3, 999) as $number) {
    if (($number % 3) === 0 || ($number % 5) === 0) {
        $total += $number;
    }
}

echo "Solution is: [{$total}]\n\n";

