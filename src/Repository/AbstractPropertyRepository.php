<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Entity\PropertyInterface;

/**
 * @extends ServiceEntityRepository<PropertyInterface>
 */
abstract class AbstractPropertyRepository extends ServiceEntityRepository
{
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
            'name' => $propertyName,
        ]);
    }
}
