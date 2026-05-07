<?php

namespace OHMedia\UtilityBundle\Twig;

use OHMedia\UtilityBundle\Service\CallToActionManager;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CallToActionExtension extends AbstractExtension
{
    public function __construct(
        private CallToActionManager $callToActionManager,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('cta_path', [$this->callToActionManager, 'getPath']),
        ];
    }
}
