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
use LongitudeOne\PropertyBundle\Repository\BooleanPropertyRepository;

#[ORM\Entity(repositoryClass: BooleanPropertyRepository::class)]
class BooleanProperty extends AbstractProperty implements PropertyInterface
{
    #[ORM\Column(name: 'bool_value', type: Types::BOOLEAN)]
    private ?bool $value = null;

    public function getValue(): ?bool
    {
        return $this->value;
    }

    public function setValue(int|string|float|bool|null $value): self
    {
        if (null === $value) {
            $this->value = null;

            return $this;
        }

        $this->value = (bool) $value;

        return $this;
    }
}
