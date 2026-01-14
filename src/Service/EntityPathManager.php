<?php

namespace OHMedia\UtilityBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

class EntityPathManager
{
    private array $providers = [];

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function addProvider(AbstractEntityPathProvider $provider): void
    {
        $this->providers[$provider->getEntityClass()] = $provider;
    }

    public function getChoices(?string $selectedEntity, array $providersWhitelist): array
    {
        $choices = [];

        if ($selectedEntity) {
            list($selectedEntityClass, $selectedEntityId)
                = explode(':', $selectedEntity);
        } else {
            $selectedEntityClass = null;
            $selectedEntityId = null;
        }

        if (!$providersWhitelist) {
            // include everything by default
            $providersWhitelist = array_keys($this->providers);
        }

        foreach ($this->providers as $entityClass => $provider) {
            if (!in_array($entityClass, $providersWhitelist)) {
                continue;
            }

            $groupLabel = $provider->getGroupLabel();

            if ($selectedEntityClass === $entityClass) {
                $queryBuilderId = (int) $selectedEntityId;
            } else {
                $queryBuilderId = null;
            }

            // up to the provider to decide if an entity should be included
            // (ie. published, not locked, etc.)
            $entities = $provider->getEntityQueryBuilder($queryBuilderId)
                ->getQuery()
                ->getResult();

            if (!$entities) {
                continue;
            }

            $choices[$groupLabel] = [];

            foreach ($entities as $entity) {
                $id = $entity->getId();

                $label = sprintf(
                    '%s (ID: %s)',
                    $provider->getEntityLabel($entity),
                    $id,
                );

                // value is like App\Entity\MyEntity:1234
                // not trying to worry about if the entity exists
                // or prevent deletion, it's just a link
                $value = implode(':', [
                    $entityClass,
                    $id,
                ]);

                $choices[$groupLabel][$label] = $value;
            }
        }

        ksort($choices);

        return $choices;
    }

    public function getEntityPath(string $entityString): ?string
    {
        list($entityClass, $entityId) = explode(':', $entityString);

        if (!isset($this->providers[$entityClass])) {
            return null;
        }

        $entity = $this->entityManager
            ->getRepository($entityClass)
            ->find($entityId);

        if (!$entity) {
            return null;
        }

        return $this->providers[$entityClass]->getEntityPath($entity);
    }
}
