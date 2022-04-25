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

class SimpleCipher
{
    private const CODEPOINT_LOWERCASE_A = 97;
    private const CODEPOINT_LOWERCASE_Z = 122;
    /**
     * @var string|null A string is encrypted by this key.
     */
    public ?string $key;
    /**
     * @var int[] $key_codepoints キーを 1 文字ずつコードポイントに変換して配列に格納した
     */
    public array $keyCodepoints;

    /**
     * @throws Exception
     */
    public function __construct(string $key = null)
    {
        $this->setKey($key);
    }

    /**
     * get cipher text.
     *
     * @param string $plainText
     *
     * @return string
     */
    public function encode(string $plainText): string
    {
        $cipherText = '';
        foreach (str_split($plainText) as $i => $char) {
            $cipherText .= chr(
                ((ord($char) - self::CODEPOINT_LOWERCASE_A) + ($this->keyCodepoints[$i] - self::CODEPOINT_LOWERCASE_A))
                % 26 + self::CODEPOINT_LOWERCASE_A
            );
        }

        return $cipherText;
    }

    /**
     * get plain text.
     *
     * @param string $cipherText
     *
     * @return string
     */
    public function decode(string $cipherText): string
    {
        $plainText = '';
        foreach (str_split($cipherText) as $i => $char) {
            $plainText .= chr(
                ((ord($char) - self::CODEPOINT_LOWERCASE_A + 26) - ($this->keyCodepoints[$i]
                                                                    - self::CODEPOINT_LOWERCASE_A)) % 26
                + self::CODEPOINT_LOWERCASE_A
            );
        }

        return $plainText;
    }

    /**
     * @param string|null $key
     *
     * @return void
     * @throws InvalidArgumentException thrown if the key contains any characters other than lowercase letters
     * @throws Exception thrown if other error occurs
     */
    private function setKey(?string $key)
    {
        if (is_null($key)) {
            $key = '';
            for ($i = 0; $i < 100; ++$i) {
                /** @noinspection PhpUnhandledExceptionInspection */
                $codepoint = random_int(
                    self::CODEPOINT_LOWERCASE_A,
                    self::CODEPOINT_LOWERCASE_Z
                ); // codepoint of lowercase alphabet.
                $key .= chr($codepoint);
                $this->keyCodepoints[] = $codepoint;
            }
        } else {
            foreach (str_split($key) as $char) {
                $codepoint = ord($char);
                if ($codepoint < self::CODEPOINT_LOWERCASE_A || self::CODEPOINT_LOWERCASE_Z < $codepoint) {
                    throw new InvalidArgumentException();
                }
                $this->keyCodepoints[] = ord($char);
            }
        }
        $this->key = $key;
    }
}
