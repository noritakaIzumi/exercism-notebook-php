<?php

function isValid(string $number): bool
{
    $number = preg_replace('/\s/', '', $number);

    if (strlen($number) <= 1) {
        return false;
    }
    if (preg_match('/^\d+$/', $number) !== 1) {
        return false;
    }

    return luhnChecksum($number) % 10 === 0;
}

function luhnChecksum(string $number): int
{
    $checksum = 0;

    foreach (str_split(strrev($number)) as $i => $digit) {
        $n = (int)$digit;
        if ($i % 2 === 1) {
            $n *= 2;
        }
        if ($n > 9) {
            $n -= 9;
        }
        $checksum += $n;
    }

    return $checksum;
}
