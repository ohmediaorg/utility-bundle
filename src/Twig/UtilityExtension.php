<?php

namespace OHMedia\UtilityBundle\Twig;

use OHMedia\UtilityBundle\Service\Uniq;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class UtilityExtension extends AbstractExtension
{
    public function __construct(private Uniq $uniqService)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('shuffle', [$this, 'shuffle']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('uniq', [$this, 'uniq']),
        ];
    }

    public function shuffle(array $array): array
    {
        shuffle($array);

        return $array;
    }

    public function uniq(int $length = 20, bool $caseSensitive = true): string
    {
        return $this->uniqService->get($length, $caseSensitive);
    }
}
