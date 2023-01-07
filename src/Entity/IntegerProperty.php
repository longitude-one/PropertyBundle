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
#[ORM\Table(name: 'lopb_properties_integer')]
#[ORM\Index(columns: ['value'], name: 'lopb_index_integer_property_value')]
#[ORM\Index(columns: ['id', 'name', 'entity_classname'], name: 'lopb_index_integer_property_link')]
#[ORM\Index(columns: ['name', 'entity_classname'], name: 'lopb_index_integer_property_property')]
#[ORM\Index(columns: ['entity_classname', 'name'], name: 'lopb_index_integer_property_entity')]
class IntegerProperty implements PropertyInterface
{
    use ActiveTrait;
    use PropertyTrait;

    #[ORM\Column(type: Types::INTEGER)]
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
