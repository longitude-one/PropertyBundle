<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Tests\Functional;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use LongitudeOne\PropertyBundle\Entity\Property;
use LongitudeOne\PropertyBundle\Repository\PropertyRepository;
use LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity;

class PropertyRepositoryTest extends WebTestCase
{
    private ?EntityManagerInterface $entityManager;
    private PropertyRepository $propertyRepository;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        /** @var Registry $doctrine */
        $doctrine = $kernel->getContainer()->get('doctrine');
        $this->entityManager = $doctrine->getManager();
        $this->propertyRepository = $this->entityManager->getRepository(Property::class);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }

    public function testFindNonExistent(): void
    {
        $linkedEntity = new ToolEntity();
        self::assertNull($this->propertyRepository->findProperty($linkedEntity, 'foo'));
        self::assertCount(0, $this->propertyRepository->findAllProperties($linkedEntity));
    }
}
