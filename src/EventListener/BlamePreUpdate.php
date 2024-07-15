<?php

namespace OHMedia\UtilityBundle\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use OHMedia\UtilityBundle\Service\Blamer;

class BlamePreUpdate
{
    public function __construct(private Blamer $blamer)
    {
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $this->blamer->blame($args->getObject());
    }
}
