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
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use LongitudeOne\PropertyBundle\Entity\AbstractProperty;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Entity\PropertyInterface;

/**
 * @extends ServiceEntityRepository<PropertyInterface>
 */
class PropertyRepository extends ServiceEntityRepository implements PropertyRepositoryInterface
{
    /**
     * @param class-string<PropertyInterface> $entityClass The class name of the entity this repository manages
     */
    public function __construct(ManagerRegistry $registry, string $entityClass = AbstractProperty::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function deleteByEntity(LinkedInterface $entity): int
    {
        $propertiesId = $this->createQueryBuilder('p')
            ->select('p.id')
            ->join('p.definition', 'd')
            ->where('p.entityId = :entityId')
            ->andWhere('d.entityClassname = :className')
            ->setParameter('entityId', $entity->getLinkedId())
            ->setParameter('className', $entity->getLinkedClassname())
            ->getQuery()
            ->execute()
        ;

        if (empty($propertiesId)) {
            return 0;
        }

        return $this->createQueryBuilder('p')
            ->delete()
            ->where('p.id in (:propertiesId)')
            ->setParameter('propertiesId', $propertiesId)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @return array<int,PropertyInterface>
     */
    public function findByEntity(LinkedInterface $linkedEntity): iterable
    {
        /** @var array<int,PropertyInterface> $properties */
        $properties = $this->createQueryBuilder('p')
            ->join('p.definition', 'd')
            ->where('p.entityId = :entityId')
            ->andWhere('d.entityClassname = :className')
            ->setParameter('entityId', $linkedEntity->getLinkedId())
            ->setParameter('className', $linkedEntity->getLinkedClassname())
            ->getQuery()
            ->getResult()
        ;

        return $properties;
    }

    /**
     * @throws NonUniqueResultException TODO Create uniq index to avoid this kind of bug
     */
    public function findByEntityAndName(LinkedInterface $linkedEntity, string $propertyName): ?PropertyInterface
    {
        return $this->createQueryBuilder('p')
            ->join('p.definition', 'd')
            ->where('p.entityId = :entityId')
            ->andWhere('d.entityClassname = :className')
            ->andWhere('d.name = :propertyName')
            ->setParameter('entityId', $linkedEntity->getLinkedId())
            ->setParameter('className', $linkedEntity->getLinkedClassname())
            ->setParameter('propertyName', $propertyName)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @return array<int,PropertyInterface>
     */
    public function findByEntityClassName(string $entityClassName): iterable
    {
        return $this->createQueryBuilder('p')
            ->join('p.definition', 'd')
            ->andWhere('d.entityClassname = :className')
            ->setParameter('className', $entityClassName)
            ->getQuery()
            ->getResult()
        ;
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
