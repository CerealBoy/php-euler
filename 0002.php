#!/usr/bin/env php
<?php
/**
 * A quick and dirty solution for Problem 2.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$total = 2;

$first = 1;
$second = 2;

while (true) {
    $new_number = ($first + $second);

    if (($new_number % 2) === 0) {
        $total += $new_number;
    }

    $first = $second;
    $second = $new_number;

    if ($new_number > 4000000) {
        break;
    }
}

echo "Total is [{$total}]\n\n";

