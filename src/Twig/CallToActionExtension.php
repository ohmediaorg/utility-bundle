<?php

namespace OHMedia\UtilityBundle\Twig;

use OHMedia\UtilityBundle\Service\EntityPathManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CallToActionExtension extends AbstractExtension
{
    public function __construct(
        private EntityPathManager $entityPathManager,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cta_path', [$this, 'path']),
        ];
    }

    public function path(CallToAction $callToAction): ?string
    {
        if ($callToAction->isTypeExternal()) {
            return $callToAction->getUrl();
        }

        return $this->entityPathManager->getEntityPath($callToAction->getEntity());
    }
}
