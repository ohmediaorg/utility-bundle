<?php

namespace OHMedia\UtilityBundle\Twig;

use OHMedia\UtilityBundle\Entity\CallToAction;
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

    public function path(?CallToAction $callToAction): ?string
    {
        if (!$callToAction) {
            return null;
        }

        if ($callToAction->isTypeExternal()) {
            return $callToAction->getUrl();
        } elseif ($callToAction->isTypeInternal()) {
            return $this->entityPathManager->getEntityPath($callToAction->getEntity());
        }

        return null;
    }
}
