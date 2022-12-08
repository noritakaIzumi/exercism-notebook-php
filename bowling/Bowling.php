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

class Game
{
    protected int $frame = 1;
    protected int $score = 0;

    protected array $count = [];
    protected int $ratio = 1;
    protected int $limit = 1;
    protected int $limit10 = 2;

    public function score(): int
    {
        if ($this->limit10 > 0) {
            throw new InvalidArgumentException();
        }

        return $this->score;
    }

    public function roll(int $pins): void
    {
        // game is end
        if ($this->limit10 === 0) {
            throw new InvalidArgumentException();
        }

        // invalid pin count
        if ($pins < 0 || $pins > 10) {
            throw new InvalidArgumentException();
        }

        // validate pin count
        $this->count[] = $pins;
        $sum = array_sum($this->count);
        if ($sum > 10) {
            throw new InvalidArgumentException();
        }

        $this->score += $pins * $this->ratio;

        $this->limit--;
        if ($this->frame >= 10) {
            $this->limit10--;
        }
        if ($this->limit === 0) {
            $this->limit = 1;
            $this->ratio = max(1, $this->ratio - 1);
        }

        // if marked
        if ($sum === 10) {
            // strike
            if (count($this->count) === 1) {
                if ($this->frame === 10) {
                    $this->limit10++;
                } elseif ($this->frame < 10) {
                    if ($this->ratio === 1) {
                        $this->ratio = 2;
                        $this->limit = 2;
                    } elseif ($this->ratio === 2) {
                        $this->ratio = 3;
                        $this->limit = 1;
                    }
                }
            } elseif ($this->frame === 10) {
                $this->ratio = 1;
                $this->limit10++;
            } elseif ($this->frame < 10) {
                $this->ratio = 2;
                $this->limit = 1;
            }

            $this->count = [];
            $this->frame++;

            return;
        }

        // open frame
        if (count($this->count) === 2) {
            $this->count = [];
            $this->frame++;
        }
    }
}
