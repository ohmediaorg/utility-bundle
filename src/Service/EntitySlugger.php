<?php

namespace OHMedia\UtilityBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use OHMedia\UtilityBundle\Entity\SluggableEntityInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class EntitySlugger
{
    private AsciiSlugger $slugger;

    public function __construct(
        private EntityIdentifier $entityIdentifier,
        private EntityManagerInterface $em
    ) {
        $this->slugger = new AsciiSlugger();
    }

    public function setSlug(SluggableEntityInterface $entity, string ...$values): void
    {
        $value = implode('-', $values);

        $value = $this->slugger->slug($value);

        $value = strtolower($value);

        $value = trim($value, '-');

        $valueLength = strlen($value);

        if ($valueLength > SluggableEntityInterface::SLUG_LENGTH) {
            $value = substr($value, 0, SluggableEntityInterface::SLUG_LENGTH);
            $valueLength = SluggableEntityInterface::SLUG_LENGTH;
        }

        $slug = $value;

        $i = 1;
        while ($this->slugExists($entity, $slug)) {
            $suffix = '-'.$i;

            $suffixLength = strlen($suffix);

            if ($valueLength + $suffixLength > SluggableEntityInterface::SLUG_LENGTH) {
                $slug = $this->slugger->slug(substr($value, 0, -$suffixLength).$suffix);
            } else {
                $slug = $this->slugger->slug($value.$suffix);
            }

            ++$i;
        }

        $entity->setSlug($slug);
    }

    private function slugExists(SluggableEntityInterface $entity, string $slug): bool
    {
        $qb = $this->em->getRepository($entity::class)
            ->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.slug = :slug');

        $params = [
            new Parameter('slug', $slug),
        ];

        if ($id = $entity->getId()) {
            $qb->andWhere('e.id <> :id');

            $params[] = new Parameter('id', $id);
        }

        return $qb->setParameters(new ArrayCollection($params))
            ->getQuery()
            ->getSingleScalarResult() > 0;
    }
}
