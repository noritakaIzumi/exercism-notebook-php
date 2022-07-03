<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

/**
 * @param int   $number
 * @param int[] $sequence
 * @param int   $base
 *
 * @return array|null
 */
function rebase(int $number, array $sequence, int $base): ?array
{
    if (
        $number < 2
        || $base < 2
        || $sequence === []
        || $sequence[0] === 0
        || min($sequence) < 0
        || max($sequence) >= $number
    ) {
        return null;
    }

    return decimalTo(toDecimal($number, $sequence), $base);
}

/**
 * @param int   $number
 * @param int[] $sequence
 *
 * @return int
 */
function toDecimal(int $number, array $sequence): int
{
    $digit = count($sequence);
    $sum = 0;
    foreach ($sequence as $i => $value) {
        $exponent = $digit - 1 - $i;
        $sum += $value * $number ** $exponent;
    }

    return $sum;
}

/**
 * @param int $n
 * @param int $base
 *
 * @return int[]
 */
function decimalTo(int $n, int $base): array
{
    $sequence = [];
    while ($n > 0) {
        [$div, $mod] = divmod($n, $base);
        $sequence[] = $mod;
        $n = $div;
    }

    return array_reverse($sequence);
}

function divmod(int $divided, int $divides): array
{
    $mod = $divided % $divides;
    $div = ($divided - $mod) / $divides;

    return array($div, $mod);
}
