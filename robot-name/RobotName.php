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
    private const ROBOT_NAMES_LIMIT = 50000;
    private static array $names = array();
    private string $name = '';

    /**
     * @throws ErrorException
     */
    public function __construct()
    {
        $this->getName();
    }

    /**
     * @return string generated robot name
     * @throws Exception if random_int fails
     * @throws ErrorException if robot limit exceeded
     */
    public function getName(): string
    {
        if ($this->name !== '') {
            return $this->name;
        }
        // prevent infinite loop
        if (count(self::$names) >= self::ROBOT_NAMES_LIMIT) {
            throw new ErrorException('Robot limit exceeded');
        }

        $name = '';
        for ($i = 0; $i < 2; ++$i) {
            $name .= chr(random_int(65, 90));
        }
        for ($i = 0; $i < 3; ++$i) {
            $name .= chr(random_int(48, 57));
        }
        if (isset(self::$names[$name])) {
            return $this->getName();
        }
        self::$names[$name] = true;
        $this->name = $name;

        return $name;
    }

    /**
     * Truncates robot names.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->name = '';
    }
}
