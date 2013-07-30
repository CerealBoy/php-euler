#!/usr/bin/env php
<?php
/**
 * Quick solution for Problem 10.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$total = 2;
$prime = 2;

while (($prime = gmp_strval(gmp_nextprime($prime))) < 2000000) {
    $total += $prime;
}

echo "The sum is [{$total}]\n\n";

