<?php

class Bob
{
    const SURE = 'Sure.';
    const CHILL_OUT = 'Whoa, chill out!';
    const CALM_DOWN = "Calm down, I know what I'm doing!";
    const FINE = 'Fine. Be that way!';
    const ANYTHING_ELSE = 'Whatever.';

    public function respondTo(string $msg): string
    {
        $msg = mb_trim($msg);

        $isYelled = Sentence::isYelled($msg);
        $isAsked = Sentence::isAsked($msg);
        $isSayNothing = Sentence::isSayNothing($msg);

        if ($isSayNothing) {
            return self::FINE;
        }

        if ($isAsked && $isYelled) {
            return self::CALM_DOWN;
        }

        if ($isAsked) {
            return self::SURE;
        }

        if ($isYelled) {
            return self::CHILL_OUT;
        }

        return self::ANYTHING_ELSE;
    }
}

class Sentence
{
    private function __construct()
    {
    }

    public static function isYelled(string $msg): bool
    {
        return preg_match('/[a-zA-Z]+/u', $msg)
               && mb_strtoupper($msg) === $msg;
    }

    public static function isAsked(string $msg): bool
    {
        return $msg[mb_strlen($msg) - 1] === '?';
    }

    public static function isSayNothing(string $msg): bool
    {
        return $msg === '';
    }
}

/**
 * @param $str
 *
 * @return array|string|string[]|null
 *
 * @see https://stackoverflow.com/questions/10066647/multibyte-trim-in-php
 */
function mb_trim($str)
{
    return preg_replace("/^\s+|\s+$/u", "", $str);
}
