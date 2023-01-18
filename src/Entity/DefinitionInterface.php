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

use Doctrine\Common\Collections\Collection;

interface DefinitionInterface
{
    public const BOOLEAN = 4;
    public const FLOAT = 2;
    public const INTEGER = 1;
    public const MIXED = 0;
    public const TEXT = 3;

    public function addProperty(PropertyInterface $property): self;

    public function getEntityClassname(): string;

    public function getName(): string;

    /**
     * @return Collection<int, PropertyInterface>
     */
    public function getProperties(): Collection;

    public function isEnabled(): bool;

    public function removeProperty(PropertyInterface $property): self;

    public function setEnabled(bool $enabled): self;

    public function setEntity(object $entity): self;

    public function setEntityClassname(string $className): self;

    public function setName(string $name): self;
}
