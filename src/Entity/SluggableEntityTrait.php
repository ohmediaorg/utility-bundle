<?php

namespace OHMedia\UtilityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait SluggableEntityTrait
{
    #[ORM\Column(length: SluggableEntityInterface::SLUG_LENGTH, unique: true)]
    #[Assert\Length(max: SluggableEntityInterface::SLUG_LENGTH)]
    #[Assert\Regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')]
    protected ?string $slug = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
}
