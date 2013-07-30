#!/usr/bin/env php
<?php
/**
 * Solution for Problem 9.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$result = 1000;
$mod = 0;

for ($a = 1; $a < 1000; $a++) {
    for ($b = $a + 1; $b < 1000; $b++) {
        $c = 1000 - $b - $a;

        if ($c <= 0) {
            continue;
        }

        if ($c > $b && (pow($a, 2) + pow($b, 2)) === pow($c, 2)) {
            $mod = ($a * $b * $c);

            break 2;
        }
    }
}

echo "The result is [{$mod}]\n\n";

