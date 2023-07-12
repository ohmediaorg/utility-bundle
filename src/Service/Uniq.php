<?php

namespace OHMedia\UtilityBundle\Service;

use OHMedia\UtilityBundle\Util\RandomString;

class Uniq
{
    private array $uniq = [];

    public function get(int $length = 20, bool $caseSensitive = true): string
    {
        $uniq = RandomString::get($length, function (string $str) {
            return !isset($this->uniq[$str]);
        }, $caseSensitive);

        $this->uniq[$uniq] = 1;

        return $uniq;
    }
}
