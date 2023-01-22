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
use Doctrine\Persistence\ManagerRegistry;
use LongitudeOne\PropertyBundle\Entity\Definition;

/**
 * @extends ServiceEntityRepository<Definition>
 *
 * @method Definition|null find($id, $lockMode = null, $lockVersion = null)
 * @method Definition|null findOneBy(array $criteria, array $orderBy = null)
 * @method Definition[]    findAll()
 * @method Definition[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefinitionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Definition::class);
    }

    /**
     * @return array<int,Definition>
     */
    public function findByClassname(string $className): array
    {
        return $this->createQueryBuilder('d')
           ->andWhere('d.entityClassname = :className')
           ->setParameter('className', $className)
           ->orderBy('d.name', 'ASC')
           ->getQuery()
           ->getResult();
    }

    public function remove(Definition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function save(Definition $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
