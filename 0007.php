#!/usr/bin/env php
<?php
/**
 * Using GMP for Problem 7.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$counter = 1;
$prime = 2;

while ($counter++ < 10001) {
    $prime = gmp_strval(gmp_nextprime((int)$prime));
}

echo "The 10,001st prime number is [{$prime}]\n\n";

