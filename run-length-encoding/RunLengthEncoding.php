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

function encode(string $input): string
{
    // return preg_replace_callback(
    //     '/(.)\1+/', // https://regexr.com/5o980
    //     function ($match) {
    //         return strlen($match[0]) . $match[1];
    //     },
    //     $input
    // );

    $result = '';
    while ($input !== '') {
        $targetChar = $input[0];
        $matched = preg_filter("/^($targetChar+).*$/", '$1', $input);
        $matchedLength = strlen($matched);
        $result .= $matchedLength === 1 ? $targetChar : "$matchedLength$targetChar";
        $input = ltrim($input, $matched);
    }

    return $result;
}

function decode(string $input): string
{
    // return preg_replace_callback(
    //     '/(\d+)(\D)/',
    //     function ($match) {
    //         return str_repeat($match[2], (int)$match[1]);
    //     },
    //     $input,
    // );

    $result = '';
    $countStr = '';
    foreach (str_split($input) as $char) {
        if (preg_match('/^\d$/', $char) === 1) {
            $countStr .= $char;
            continue;
        }
        $count = $countStr === '' ? 1 : (int)$countStr;
        $result .= str_repeat($char, $count);
        $countStr = '';
    }

    return $result;
}
