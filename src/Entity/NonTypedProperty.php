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
use LongitudeOne\PropertyBundle\Repository\NonTypedPropertyRepository;

#[ORM\Entity(repositoryClass: NonTypedPropertyRepository::class)]
class NonTypedProperty extends AbstractProperty implements PropertyInterface
{
    #[ORM\Column(name: 'non_typed_value', type: Types::TEXT)]
    private string $value;

    public function __construct(DefinitionInterface $definition)
    {
        parent::__construct($definition);
        $this->value = serialize(null);
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

    public function setValue(float|bool|int|string|null $value): PropertyInterface
    {
        $this->value = serialize($value);

        return $this;
    }
}
