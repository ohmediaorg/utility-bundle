<?php

namespace OHMedia\UtilityBundle\Twig;

use OHMedia\UtilityBundle\Service\EntityPathManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EntityPathExtension extends AbstractExtension
{
    public function __construct(
        private EntityPathManager $entityPathManager,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('entity_path', [$this->entityPathManager, 'getEntityPath']),
        ];
    }
}
