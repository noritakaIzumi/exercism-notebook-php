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

class BeerSong
{
    public function verse(int $number): string
    {
        $getBottles = static function (int $n): string {
            if ($n <= 0) {
                return 'no more bottles';
            }
            if ($n === 1) {
                return '1 bottle';
            }

            return "$n bottles";
        };

        $phrase1 = ucfirst(
            sprintf(
                "%s of beer on the wall, %s of beer.",
                $getBottles($number),
                $getBottles($number),
            )
        );
        $phrase2 = (static function () use ($number): string {
            if ($number <= 0) {
                return 'Go to the store and buy some more';
            }
            if ($number === 1) {
                return 'Take it down and pass it around';
            }

            return 'Take one down and pass it around';
        })();
        $phrase3 = sprintf(
            '%s of beer on the wall.',
            $getBottles($number <= 0 ? 99 : $number - 1),
        );

        $verse = "$phrase1\n$phrase2, $phrase3";
        if ($number > 0) {
            $verse .= "\n";
        }

        return $verse;
    }

    public function verses(int $start, int $finish): string
    {
        return implode("\n", array_map(fn($n) => $this->verse($n), range($start, $finish)));
    }

    public function lyrics(): string
    {
        return $this->verses(99, 0);
    }
}
