#!/usr/bin/env php
<?php
/**
 * A solution for Problem 5.
 *
 * @author Allan Shone <allan.shone@yahoo.com>
 */

$total = 0;
while (true) {
    $total += (20 * 19);

    if (Is::Valid($total)) {
        break;
    }
}

class Is
{
    public static function Valid($total)
    {
        if (empty(self::$checks)) {
            self::$checks = range(19, 11);
        }

        foreach (self::$checks as $num) {
            if (($total % $num) !== 0) {
                return false;
            }
        }

        return true;
    }

    private static $checks = array();
}

echo "The solution is [{$total}]\n\n";

