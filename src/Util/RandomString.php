<?php

namespace OHMedia\UtilityBundle\Util;

class RandomString
{
    /**
     * @param int length - the length of the generated string
     * @param callable verify - user-provided function to return true if the string is unique
     * @param bool caseSensitive - if true, uppercase letters will be excluded from the string
     */
    public static function get(
        int $length,
        callable $verify = null,
        bool $caseSensitive = true
    ): string {
        if (!$verify) {
            $verify = function (string $str) {
                return true;
            };
        }

        $numbers = implode('', range(0, 9));
        $lowercase = implode('', range('a', 'z'));
        $uppercase = strtoupper($lowercase);

        $chars = $numbers.$lowercase;

        if (!$caseSensitive) {
            $chars .= $uppercase;
        }

        $lowercaseMax = strlen($lowercase) - 1;

        $charsMax = strlen($chars) - 1;

        do {
            $str = $lowercase[rand(0, $lowercaseMax)];

            for ($i = 1; $i < $length; ++$i) {
                $str .= $chars[rand(0, $charsMax)];
            }
        } while (!$verify($str));

        return $str;
    }
}
