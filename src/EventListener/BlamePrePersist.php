<?php

namespace OHMedia\UtilityBundle\EventListener;

use Doctrine\ORM\Event\PrePersistEventArgs;
use OHMedia\UtilityBundle\Service\Blamer;

class BlamePrePersist
{
    public function __construct(private Blamer $blamer)
    {
    }

    public function prePersist(PrePersistEventArgs $args)
    {
        $this->blamer->blame($args->getObject());
    }
}
