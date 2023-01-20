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
use LongitudeOne\PropertyBundle\Entity\AbstractProperty;
use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Entity\NonTypedProperty;
use LongitudeOne\PropertyBundle\Exception\EntityNotFoundException;
use LongitudeOne\PropertyBundle\Repository\PropertyRepositoryInterface;

class PropertyService
{
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

    public function has(string $fqcn): bool
    {
        foreach ($this->entities as $entity) {
            if ($entity['class'] === $fqcn) {
                return true;
            }
        }

        return false;
    }

    public function getProperties(LinkedInterface $instance): Collection
    {
        $collection = new ArrayCollection();
        $properties = $this->propertyRepository->findByEntity($instance);
        foreach ($properties as $property) {
            $collection->add($property);
        }

        return $collection;
    }
}
