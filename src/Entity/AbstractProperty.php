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
use LongitudeOne\PropertyBundle\Repository\PropertyRepository;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ORM\Table(name: 'lopb_properties')]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    Types::BOOLEAN => BoolProperty::class,
    Types::FLOAT => FloatProperty::class,
    Types::INTEGER => IntegerProperty::class,
    self::NON_TYPED => NonTypedProperty::class,
    Types::STRING => StringProperty::class,
])]
#[ORM\Index(columns: ['id', 'name', 'entity_classname'], name: 'lopb_index_property_link')]
#[ORM\Index(columns: ['name', 'entity_classname'], name: 'lopb_index_property_property')]
#[ORM\Index(columns: ['entity_classname', 'name'], name: 'lopb_index_property_entity')]
#[ORM\Index(columns: ['bool_value'], name: 'lopb_index_bool_property_value')]
#[ORM\Index(columns: ['float_value'], name: 'lopb_index_float_property_value')]
#[ORM\Index(columns: ['int_value'], name: 'lopb_index_integer_property_value')]
#[ORM\Index(columns: ['string_value'], name: 'lopb_index_string_property_value')]
abstract class AbstractProperty implements PropertyInterface
{
    use EnabledTrait;
    use PropertyTrait;

    public const NON_TYPED = 'non_typed';
}
