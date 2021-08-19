<?php

/*
This is only a SKELETON file for the "Hamming" exercise. It's been provided as a
convenience to get you started writing code faster.

Remove this comment before submitting your exercise.
*/

function distance(string $strandA, string $strandB): int
{
    //
    // YOUR CODE GOES HERE
    //
    $length = strlen($strandA);
    if ($length !== strlen($strandB)) {
        throw new InvalidArgumentException('DNA strands must be of equal length.');
    }

    $diffCount = 0;

    for ($i = 0; $i < $length; ++$i) {
        if ($strandA[$i] !== $strandB[$i]) {
            $diffCount++;
        }
    }

    return $diffCount;
}
