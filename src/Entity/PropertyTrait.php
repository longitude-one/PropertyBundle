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

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait PropertyTrait
{
    #[ORM\Column(type: Types::STRING, length: 255)]
    private string $entityClassname;

    #[ORM\Column(type: Types::INTEGER)]
    private int $entityId;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 31)]
    private string $name;

    public function getEntityClassname(): string
    {
        return $this->entityClassname;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setEntity(LinkedInterface $linkedEntity): PropertyInterface
    {
        $this->entityClassname = $linkedEntity->getLinkedClassname();
        $this->entityId = $linkedEntity->getLinkedId();

        return $this;
    }

    public function setName(string $name): PropertyInterface
    {
        $this->name = $name;

        return $this;
    }
}
