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
use LongitudeOne\PropertyBundle\Exception\InvalidEntityException;
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
// TODO add definition_id to this index
#[ORM\Index(columns: ['entity_id'], name: 'lopb_index_property_entity_id')]
#[ORM\Index(columns: ['bool_value'], name: 'lopb_index_bool_property_value')]
#[ORM\Index(columns: ['float_value'], name: 'lopb_index_float_property_value')]
#[ORM\Index(columns: ['int_value'], name: 'lopb_index_integer_property_value')]
#[ORM\Index(columns: ['string_value'], name: 'lopb_index_string_property_value')]
abstract class AbstractProperty implements PropertyInterface
{
    public const NON_TYPED = 'non_typed';

    #[ORM\ManyToOne(targetEntity: Definition::class, inversedBy: 'properties')]
    #[ORM\JoinColumn(nullable: false)]
    private DefinitionInterface $definition;

    #[ORM\Column(type: Types::INTEGER)]
    private int $entityId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    public function __construct(DefinitionInterface $definition)
    {
        $this->definition = $definition;
    }

    public function getDefinition(): DefinitionInterface
    {
        return $this->definition;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setDefinition(DefinitionInterface $definition): self
    {
        $this->definition = $definition;

        return $this;
    }

    public function setEntity(LinkedInterface $linkedEntity): self
    {
        if (empty($this->getDefinition()->getEntityClassname())) {
            $this->getDefinition()->setEntityClassname($linkedEntity->getLinkedClassname());
        }

        if ($linkedEntity->getLinkedClassname() !== $this->getDefinition()->getEntityClassname()) {
            throw new InvalidEntityException($linkedEntity->getLinkedClassname(), $this->getDefinition()->getEntityClassname());
        }

        $this->entityId = $linkedEntity->getLinkedId();

        return $this;
    }
}
