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
use LongitudeOne\PropertyBundle\Repository\IntegerPropertyRepository;

#[ORM\Entity(repositoryClass: IntegerPropertyRepository::class)]
class IntegerProperty extends AbstractProperty implements PropertyInterface
{
    #[ORM\Column(name: 'int_value', type: Types::INTEGER)]
    private ?int $value = null;

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int|string|float|bool|null $value): PropertyInterface
    {
        if (null === $value) {
            $this->value = null;

            return $this;
        }

        $this->value = (int) $value;

        return $this;
    }
}
