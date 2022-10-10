<?php

namespace LongitudeOne\PropertyBundle\Tests\Functional;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use LogicException;
use Symfony\Component\HttpKernel\KernelInterface;

class DatabaseTestCase extends WebTestCase
{
    private ?EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        if ('test' !== $kernel->getEnvironment()) {
            throw new LogicException('Execution only in Test environment possible!');
        }

        $this->initDatabase($kernel);
    }

    protected function tearDown(): void
    {
        if (null !== $this->entityManager) {
            $this->entityManager->close();
            $this->entityManager = null;
        }
    }

    protected function initDatabase(KernelInterface $kernel): void
    {
        $this->entityManager = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        if (null === $this->entityManager) {
            throw new \Exception("Unable to load doctrine service. Check your test config!");
        }

        $metaData = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->updateSchema($metaData);
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}