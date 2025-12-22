<?php

namespace OHMedia\UtilityBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use OHMedia\UtilityBundle\Entity\CallToAction;

/**
 * @extends ServiceEntityRepository<CallToAction>
 */
class CallToActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CallToAction::class);
    }
}
