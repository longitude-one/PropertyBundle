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

trait ExtendableTrait
{
    /**
     * @var PropertyInterface[]
     */
    private iterable $properties;

    /**
     * @return PropertyInterface[]
     */
    public function getProperties(): iterable
    {
        return $this->properties;
    }

    /**
     * @param PropertyInterface[] $properties
     */
    public function setProperties(iterable $properties): self
    {
        $this->properties = $properties;

        return $this;
    }
}
