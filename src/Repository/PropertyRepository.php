<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Entity\Property;
use LongitudeOne\PropertyBundle\Entity\PropertyInterface;

/**
 * @extends ServiceEntityRepository<PropertyInterface>
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass = Property::class)
    {
        parent::__construct($registry, $entityClass);
    }

    /**
     * @return array<int,PropertyInterface>
     */
    public function findAllProperties(LinkedInterface $linkedEntity): iterable
    {
        $properties = $this->findBy([
            'entityId' => $linkedEntity->getLinkedId(),
            'entityClassname' => $linkedEntity->getLinkedId(),
        ]);

        if ($linkedEntity instanceof ExtendableInterface) {
            $linkedEntity->setProperties($properties);
        }

        return $properties;
    }

    public function findProperty(LinkedInterface $linkedEntity, string $propertyName): ?PropertyInterface
    {
        return $this->findOneBy([
            'entityId' => $linkedEntity->getLinkedId(),
            'entityClassname' => $linkedEntity->getLinkedId(),
            'propertyName' => $propertyName,
        ]);
    }
}
