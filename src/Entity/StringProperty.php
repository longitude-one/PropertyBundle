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
use LongitudeOne\PropertyBundle\Repository\StringPropertyRepository;

#[ORM\Entity(repositoryClass: StringPropertyRepository::class)]
class StringProperty extends AbstractProperty implements PropertyInterface
{
    #[ORM\Column(name: 'string_value', type: Types::STRING)]
    private ?string $value = null;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(float|bool|int|string|null $value): self
    {
        if (null === $value) {
            $this->value = null;

            return $this;
        }

        $this->value = (string) $value;

        return $this;
    }
}
