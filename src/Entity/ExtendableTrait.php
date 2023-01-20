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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait ExtendableTrait
{
    /**
     * @var Collection<int, PropertyInterface>
     */
    private Collection $properties;

    public function addProperty(PropertyInterface $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setEntity($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PropertyInterface>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function removeProperty(PropertyInterface $property): self
    {
        $this->properties->removeElement($property);

        return $this;
    }

    /**
     * @param Collection<int, PropertyInterface> $properties
     */
    public function setProperties(Collection $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    protected function initializeProperties(): void
    {
        $this->properties = new ArrayCollection();
    }
}
