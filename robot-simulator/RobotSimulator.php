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

class Robot
{
    public const DIRECTION_NORTH = 0;
    public const DIRECTION_WEST = 1;
    public const DIRECTION_SOUTH = 2;
    public const DIRECTION_EAST = 3;

    /**
     * position as coordinate {x, y}
     *
     * @var array{int, int}
     */
    public array $position;

    /**
     * north, west, south, east as int
     *
     * @var int
     */
    public int $direction;

    public function __construct(array $position, int $direction)
    {
        $this->position = $position;
        $this->direction = $direction;
    }

    public function turnRight(): self
    {
        $this->direction = ($this->direction + 3) % 4;

        return $this;
    }

    public function turnLeft(): self
    {
        $this->direction = ($this->direction + 1) % 4;

        return $this;
    }

    public function advance(): self
    {
        switch ($this->direction) {
            case self::DIRECTION_NORTH:
                $this->position[1]++;
                break;
            case self::DIRECTION_SOUTH:
                $this->position[1]--;
                break;
            case self::DIRECTION_EAST:
                $this->position[0]++;
                break;
            case self::DIRECTION_WEST:
                $this->position[0]--;
                break;
        }

        return $this;
    }

    /**
     * parse chars and move robot.
     *
     * @param string $instructions
     *
     * @return $this
     * @throws InvalidArgumentException if a char doesn't match with L/R/A
     */
    public function instructions(string $instructions): self
    {
        foreach (str_split($instructions) as $instruction) {
            switch (strtoupper($instruction)) {
                case 'L':
                    $this->turnLeft();
                    break;
                case 'R':
                    $this->turnRight();
                    break;
                case 'A':
                    $this->advance();
                    break;
                default:
                    throw new InvalidArgumentException();
            }
        }

        return $this;
    }
}
