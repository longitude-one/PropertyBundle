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
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use LongitudeOne\PropertyBundle\Repository\DefinitionRepository;

// TODO Index lopb_index_definition_name shall be uniq!
#[ORM\Entity(repositoryClass: DefinitionRepository::class)]
#[ORM\Index(columns: ['name', 'entity_classname'], name: 'lopb_index_definition_name')]
#[ORM\Index(columns: ['entity_classname'], name: 'lopb_index_property_entity')]
class Definition implements DefinitionInterface
{
    #[ORM\Column]
    private bool $enabled = false;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $entityClassname;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 31)]
    private string $name;

    /**
     * @var ArrayCollection<int, PropertyInterface>
     */
    #[ORM\OneToMany(mappedBy: 'definition', targetEntity: AbstractProperty::class, orphanRemoval: true)]
    private Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function addProperty(PropertyInterface $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->setDefinition($this);
        }

        return $this;
    }

    public function getEntityClassname(): string
    {
        return $this->entityClassname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, PropertyInterface>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function removeProperty(PropertyInterface $property): DefinitionInterface
    {
        if ($this->properties->removeElement($property)) {
            // set the owning side to null (unless already changed)
            if ($property->getDefinition() === $this) {
                // We SHALL NOT move a property from a definition to another
                unset($property);
            }
        }

        return $this;
    }

    public function setEnabled(bool $enabled): DefinitionInterface
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function setEntity(object $entity): DefinitionInterface
    {
        if ($entity instanceof LinkedInterface) {
            return $this->setEntityClassname($entity->getLinkedClassname());
        }

        $this->entityClassname = get_class($entity);

        return $this;
    }

    public function setEntityClassname(string $className): DefinitionInterface
    {
        $this->entityClassname = $className;

        return $this;
    }

    public function setName(string $name): DefinitionInterface
    {
        $this->name = $name;

        return $this;
    }
}
