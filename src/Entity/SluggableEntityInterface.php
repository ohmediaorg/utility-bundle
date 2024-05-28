<?php

namespace OHMedia\UtilityBundle\Entity;

interface SluggableEntityInterface
{
    public const SLUG_LENGTH = 255;

    public function getId(): ?int;

    public function getSlug(): ?string;

    public function setSlug(string $slug): static;
}
