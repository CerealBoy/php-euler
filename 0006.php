#!/usr/bin/env php
<?php
/**
 * Quick and dirty solution for Problem 6.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$numbers = range(2, 100);

$sum = 0;
$mul = 1;

foreach ($numbers as $num) {
    $sum += ($num * $num);
    $mul += $num;
}

$mul = pow($mul, 2) - $sum;

echo "The difference is [{$mul}]\n\n";

