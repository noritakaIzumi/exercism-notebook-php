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

class School
{
    /**
     * @var array<int, string[]> $classes
     */
    private array $classes = array();

    public function add(string $name, int $grade): void
    {
        if (!isset($this->classes[$grade])) {
            $this->classes[$grade] = array();
        }
        $this->classes[$grade][] = $name;
    }

    /**
     * @param int $grade
     *
     * @return string[]
     */
    public function grade(int $grade): array
    {
        return $this->classes[$grade] ?? array();
    }

    public function studentsByGradeAlphabetical(): array
    {
        foreach ($this->classes as $grade => $students) {
            sort($students);
            $this->classes[$grade] = $students;
        }
        ksort($this->classes);

        return $this->classes;
    }
}
