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
 * @property string[] $numbers
 */
class PhoneNumber
{
    public function __construct(string $rawNumber)
    {
        $this->setNumbers($rawNumber);
    }

    protected function setNumbers(string $rawNumber): void
    {
        if (preg_match('/[A-Za-z]/', $rawNumber)) {
            throw new InvalidArgumentException('letters not permitted');
        }

        if (!preg_match('/\A[()\-+. \d]+\Z/', $rawNumber)) {
            throw new InvalidArgumentException('punctuations not permitted');
        }

        preg_match_all('/\d/', $rawNumber, $matches);
        $this->numbers = array_shift($matches);

        $count = count($this->numbers);

        if ($count < 10) {
            throw new InvalidArgumentException('incorrect number of digits');
        }

        if ($count > 11) {
            throw new InvalidArgumentException('more than 11 digits');
        }

        if ($count === 11) {
            $countryNumber = array_shift($this->numbers);
            if ($countryNumber !== '1') {
                throw new InvalidArgumentException('11 digits must start with 1');
            }
        }

        if ($this->numbers[0] === '0') {
            throw new InvalidArgumentException('area code cannot start with zero');
        }

        if ($this->numbers[0] === '1') {
            throw new InvalidArgumentException('area code cannot start with one');
        }

        if ($this->numbers[3] === '0') {
            throw new InvalidArgumentException('exchange code cannot start with zero');
        }

        if ($this->numbers[3] === '1') {
            throw new InvalidArgumentException('exchange code cannot start with one');
        }
    }

    public function number(): string
    {
        if (count($this->numbers) === 11) {
            array_shift($this->numbers);
        }

        return implode('', $this->numbers);
    }
}
