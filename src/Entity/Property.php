<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use LongitudeOne\PropertyBundle\Repository\PropertyRepository;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ORM\Table(name: 'lopb_properties')]
class Property implements PropertyInterface
{
    #[ORM\Column(type: 'string', length: 255)]
    private string $entityClassname;

    #[ORM\Column(type: 'int')]
    private int $entityId;

    #[ORM\Column(type: 'string', length: 31)]
    private string $name;

    #[ORM\Column(type: 'text')]
    private string $value;

    public function getEntityClassname(): string
    {
        return $this->entityClassname;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
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
