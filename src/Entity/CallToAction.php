<?php

namespace OHMedia\UtilityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OHMedia\UtilityBundle\Repository\CallToActionRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CallToActionRepository::class)]
class CallToAction
{
    public const TYPE_EXTERNAL = 'external';
    public const TYPE_INTERNAL = 'internal';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 8)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    #[Assert\When(
        expression: 'this.isTypeInternal()',
        constraints: [
            new Assert\NotBlank(),
        ],
    )]
    private ?string $entity = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(max: 255)]
    #[Assert\When(
        expression: 'this.isTypeExternal()',
        constraints: [
            new Assert\NotBlank(),
        ],
    )]
    private ?string $url = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $text = null;

    #[ORM\Column(nullable: true)]
    private ?bool $new_window = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isTypeExternal(): bool
    {
        return self::TYPE_EXTERNAL === $this->type;
    }

    public function isTypeInternal(): bool
    {
        return self::TYPE_INTERNAL === $this->type;
    }

    public function getEntity(): ?string
    {
        return $this->entity;
    }

    public function setEntity(?string $entity): static
    {
        $this->entity = $entity;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function isNewWindow(): ?bool
    {
        return $this->new_window;
    }

    public function setNewWindow(?bool $new_window): static
    {
        $this->new_window = $new_window;

        return $this;
    }
}
