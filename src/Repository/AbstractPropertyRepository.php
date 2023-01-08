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
abstract class AbstractPropertyRepository extends ServiceEntityRepository implements PropertyRepositoryInterface
{
    /**
     * @return array<int,PropertyInterface>
     */
    public function findByEntity(LinkedInterface $linkedEntity): iterable
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

    public function findByEntityAndName(LinkedInterface $linkedEntity, string $propertyName): ?PropertyInterface
    {
        return $this->findOneBy([
            'entityId' => $linkedEntity->getLinkedId(),
            'entityClassname' => $linkedEntity->getLinkedId(),
            'name' => $propertyName,
        ]);
    }

    public function remove(PropertyInterface $property, bool $flush = false): void
    {
        $this->getEntityManager()->remove($property);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function save(PropertyInterface $property, bool $flush = false): void
    {
        $this->getEntityManager()->persist($property);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
