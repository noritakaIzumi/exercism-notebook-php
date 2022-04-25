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

class Series
{
    private string $digits;

    /**
     * @param string $digits
     */
    public function __construct(string $digits)
    {
        if (preg_match('/\D/', $digits) === 1) {
            throw new InvalidArgumentException();
        }
        $this->digits = $digits;
    }

    public function largestProduct(int $span): int
    {
        if ($span < 0) {
            throw new InvalidArgumentException();
        }

        if ($span === 0) {
            return 1;
        }

        $length = strlen($this->digits);
        if ($span > $length) {
            throw new InvalidArgumentException();
        }

        $maxProduct = 0;
        for ($i = 0; $i < $length - $span + 1; ++$i) {
            $maxProduct = max(
                $maxProduct,
                array_reduce(
                    str_split(substr($this->digits, $i, $span)),
                    function ($carry, $item) {
                        return $carry * (int)$item;
                    },
                    1
                )
            );
        }

        return $maxProduct;
    }
}
