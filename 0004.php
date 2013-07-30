#!/usr/bin/env php
<?php
/**
 * Quick solution for Problem 4.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$palindrome = 0;

$first = range(2, 999);
$second = range(2, 999);

foreach ($first as $numba) {
    foreach ($second as $numbb) {
        $product = ($numba * $numbb);

        if ($product < $palindrome)
            continue;

        if (isPalindrome($product)) {
            $palindrome = $product;
        }
    }
}

function isPalindrome($number) {
    $i = 0;
    $k = str_split($number);
    $j = count($k) - 1;

    for ($i = 0; $i < (count($k) / 2); $i++, $j--) {
        if ($k[$i] !== $k[$j]) {
            return false;
        }
    }

    return true;
}

echo "Found the palindrome of [{$palindrome}]\n\n";

