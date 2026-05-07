<?php

namespace OHMedia\UtilityBundle\Service;

use OHMedia\UtilityBundle\Entity\CallToAction;

class CallToActionManager
{
    public function __construct(
        private EntityPathManager $entityPathManager,
    ) {
    }

    public function getPath(?CallToAction $callToAction): ?string
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
