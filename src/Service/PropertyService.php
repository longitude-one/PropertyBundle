<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Service;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use LongitudeOne\PropertyBundle\Dto\PropertyDto;
use LongitudeOne\PropertyBundle\Entity\AbstractProperty;
use LongitudeOne\PropertyBundle\Entity\BooleanProperty;
use LongitudeOne\PropertyBundle\Entity\Definition;
use LongitudeOne\PropertyBundle\Entity\DefinitionInterface;
use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
use LongitudeOne\PropertyBundle\Entity\FloatProperty;
use LongitudeOne\PropertyBundle\Entity\IntegerProperty;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Entity\NonTypedProperty;
use LongitudeOne\PropertyBundle\Entity\PropertyInterface;
use LongitudeOne\PropertyBundle\Entity\StringProperty;
use LongitudeOne\PropertyBundle\Exception\EntityNotFoundException;
use LongitudeOne\PropertyBundle\Repository\DefinitionRepository;
use LongitudeOne\PropertyBundle\Repository\PropertyRepositoryInterface;

class PropertyService
{
    private DefinitionRepository $definitionRepository;
    /**
     * @var array<string, array<string, string>> list of all extendable classes
     */
    private array $entities = [];

    private PropertyRepositoryInterface $propertyRepository;

    /**
     * @param array<string, array<string, string>> $entities list of all extendable classes
     */
    public function __construct(private readonly EntityManagerInterface $entityManager, array $entities)
    {
        foreach ($entities as $keyword => $entity) {
            if (!class_exists($entity['class'])) {
                throw new EntityNotFoundException('Class "'.$entity['class'].'" not found! Did you misspell your entity in the config/properties.yaml file?');
            }

            $this->entities[$keyword] = $entity;
        }

        $this->propertyRepository = $this->entityManager->getRepository(AbstractProperty::class);
        $this->definitionRepository = $this->entityManager->getRepository(Definition::class);
    }

    /**
     * Delete all properties from an entity. Especially used because we cannot set orphanRemoval to true.
     */
    public function deleteAll(LinkedInterface $entity, bool $flush = false): int
    {
        $deleted = $this->propertyRepository->deleteByEntity($entity);

        if ($flush) {
            $this->entityManager->flush();
        }

        return $deleted;
    }

    /**
     * @return Collection<int, PropertyInterface>
     */
    public function getAllProperties(LinkedInterface $entity): Collection
    {
        $collection = new ArrayCollection();
        $properties = $this->getProperties($entity);
        foreach ($properties as $property) {
            $collection->add($property);
        }

        // Complete with definition
        $definitions = $this->definitionRepository->findByClassname($entity::class);

        foreach ($definitions as $definition) {
            if ($this->collectionHasProperty($collection, $definition)) {
                continue;
            }

            $property = $this->createProperty($definition, $entity);
            $collection->add($property);
        }

        return $collection;
    }

    /**
     * @return array<string, string>
     */
    public function getChoices(): array
    {
        $associativeArray = [];

        foreach ($this->entities as $keyword => $entity) {
            $associativeArray[$keyword] = $entity['class'];
        }

        return $associativeArray;
    }

    /**
     * @return array<string, array<string, string>> $classes list of all extendable classes
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @return array<string, string> definition of entity
     */
    public function getEntity(string $keyword): array
    {
        if (!key_exists($keyword, $this->entities)) {
            throw new EntityNotFoundException('Entity "'.$keyword.'" not found! Did you miss to declare your entity in the config/properties.yaml file?');
        }

        return $this->entities[$keyword];
    }

    /**
     * @return Collection<int, PropertyInterface>
     */
    public function getProperties(LinkedInterface $instance): Collection
    {
        $collection = new ArrayCollection();
        $properties = $this->propertyRepository->findByEntity($instance);
        foreach ($properties as $property) {
            $collection->add($property);
        }

        return $collection;
    }

    /**
     * @return PropertyDto[]>
     */
    public function getPropertiesDto(ExtendableInterface $extendableEntity): array
    {
        $propertiesDto = [];
        foreach ($extendableEntity->getProperties() as $property) {
            $propertiesDto[] = $this->getPropertyDto($property);
        }

        return $propertiesDto;
    }

    public function has(string $fqcn): bool
    {
        foreach ($this->entities as $entity) {
            if ($entity['class'] === $fqcn) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ArrayCollection<int, PropertyInterface> $collection
     */
    private function collectionHasProperty(ArrayCollection $collection, DefinitionInterface $definition): bool
    {
        foreach ($collection as $property) {
            if ($property->getDefinition()->getName() === $definition->getName()) {
                return true;
            }
        }

        return false;
    }

    private function createProperty(DefinitionInterface $definition, LinkedInterface $entity): PropertyInterface
    {
        $property = match ($definition->getType()) {
            DefinitionInterface::TYPE_TEXT => new StringProperty($definition),
            DefinitionInterface::TYPE_INTEGER => new IntegerProperty($definition),
            DefinitionInterface::TYPE_BOOLEAN => new BooleanProperty($definition),
            DefinitionInterface::TYPE_FLOAT => new FloatProperty($definition),
            default => new NonTypedProperty($definition),
        };

        $property->setEntity($entity);

        return $property;
    }

    private function getPropertyDto(PropertyInterface $property): PropertyDto
    {
        $fieldClassname = match ($property->getDefinition()->getType()) {
            DefinitionInterface::TYPE_INTEGER => IntegerField::class,
            DefinitionInterface::TYPE_BOOLEAN => BooleanField::class,
            DefinitionInterface::TYPE_FLOAT => NumberField::class,
            default => TextField::class,
        };

        /** @var TextField|IntegerField|BooleanField|NumberField $field */
        $field = $fieldClassname::new($property->getDefinition()->getName());
        $field->setProperty($property->getDefinition()->getName());
        $field->setLabel($property->getDefinition()->getName());
        $field->setValue($property->getValue());
        $field->setFieldFqcn(match ($property->getDefinition()->getType()) {
            DefinitionInterface::TYPE_TEXT => StringProperty::class,
            DefinitionInterface::TYPE_INTEGER => IntegerProperty::class,
            DefinitionInterface::TYPE_BOOLEAN => BooleanProperty::class,
            DefinitionInterface::TYPE_FLOAT => FloatProperty::class,
            default => NonTypedProperty::class,
        });

        $propertyDto = new PropertyDto();
        $propertyDto->setFieldDto($field->getAsDto());
        $propertyDto->setLabel($property->getDefinition()->getName());
        $propertyDto->setType($property->getDefinition()->getType());
        $propertyDto->setValue($property->getValue());
        $propertyDto->setName($property->getDefinition()->getName());

        return $propertyDto;
    }
}
