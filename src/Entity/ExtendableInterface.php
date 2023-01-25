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

interface ExtendableInterface
{
    public function addProperty(PropertyInterface $property): self;

    /**
     * @return Collection<int, PropertyInterface>
     */
    public function getProperties(): Collection;

    public function removeProperty(PropertyInterface $property): self;

    /**
     * @param Collection<int, PropertyInterface> $properties
     */
    public function setProperties(Collection $properties): self;
}
