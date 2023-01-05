<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use LongitudeOne\PropertyBundle\Repository\PropertyRepository;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ORM\Table(name: 'lopb_properties')]
class Property implements PropertyInterface
{
    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $active = false;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $entityClassname;

    #[ORM\Column(type: Types::INTEGER)]
    private int $entityId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 31)]
    private string $name;

    #[ORM\Column(type: Types::STRING)]
    private string $value;

    public function __construct()
    {
        $this->value = serialize(null);
    }

    public function getEntityClassname(): string
    {
        return $this->entityClassname;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): bool|float|int|null|string
    {
        $value = unserialize($this->value, ['allowed_classes' => false]);

        if (false === $value && $this->value !== serialize(false)) {
            return null;
        }

        if (is_bool($value) || is_string($value) || is_int($value) || is_null($value) || is_float($value)) {
            return $value;
        }

        return null;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function setEntity(LinkedInterface $linkedEntity): PropertyInterface
    {
        $this->entityClassname = $linkedEntity->getLinkedClassname();
        $this->entityId = $linkedEntity->getLinkedId();

        return $this;
    }

    public function setName(string $name): PropertyInterface
    {
        $this->name = $name;

        return $this;
    }

    public function setValue(float|bool|int|string|null $value): PropertyInterface
    {
        $this->value = serialize($value);

        return $this;
    }
}
