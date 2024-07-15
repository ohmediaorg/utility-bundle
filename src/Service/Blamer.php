<?php

namespace OHMedia\UtilityBundle\Service;

use OHMedia\UtilityBundle\Entity\BlameableEntityTrait;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Blamer
{
    public function __construct(private TokenStorageInterface $tokenStorage)
    {
    }

    public function blame($entity)
    {
        $class = get_class($entity);

        if (!in_array(BlameableEntityTrait::class, $this->getTraits($class))) {
            return;
        }

        $token = $this->tokenStorage->getToken();

        $user = $token ? $token->getUser() : null;

        $by = $user instanceof UserInterface
            ? $user->getUserIdentifier()
            : null;

        $at = new \DateTime();

        if (!$entity->getCreatedAt()) {
            $entity->setCreatedAt($at);
        }

        if (!$entity->getCreatedBy()) {
            $entity->setCreatedBy($by);
        }

        $entity
            ->setUpdatedAt($at)
            ->setUpdatedBy($by)
        ;
    }

    private function getTraits($class)
    {
        $traits = [];

        do {
            $traits = array_merge(class_uses($class), $traits);
        } while ($class = get_parent_class($class));

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait), $traits);
        }

        return array_unique($traits);
    }
}
