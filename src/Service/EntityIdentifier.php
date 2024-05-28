<?php

namespace OHMedia\UtilityBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

class EntityIdentifier
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function get(mixed $entity): ?string
    {
        if (!is_object($entity)) {
            return null;
        }

        try {
            $metadata = $this->em->getClassMetadata($entity::class);

            $identifier = $metadata->getSingleIdReflectionProperty();

            return (string) $identifier->getValue($entity);
        } catch (\Exception $e) {
            return null;
        }
    }
}
