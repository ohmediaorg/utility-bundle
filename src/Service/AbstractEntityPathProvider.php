<?php

namespace OHMedia\UtilityBundle\Service;

use Doctrine\ORM\QueryBuilder;

abstract class AbstractEntityPathProvider
{
    abstract public function getEntityClass(): string;

    abstract public function getGroupLabel(): string;

    abstract public function getEntityQueryBuilder(): QueryBuilder;

    abstract public function getEntityPath(mixed $entity): ?string;

    public function getEntityLabel(mixed $entity): string
    {
        return (string) $entity;
    }
}
