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

class Clock
{
    protected DateTime $time;

    public function __construct(int $hour, int $minute = 0)
    {
        $this->time = date_create()->setTime($hour, $minute)->setDate(1, 1, 1);
    }

    public function __toString(): string
    {
        return $this->time->format('H:i');
    }

    public function add(int $minute): self
    {
        $this->time->add(DateInterval::createFromDateString("$minute minutes"));

        return $this;
    }

    public function sub(int $minute): self
    {
        $this->time->sub(DateInterval::createFromDateString("$minute minutes"));

        return $this;
    }
}
