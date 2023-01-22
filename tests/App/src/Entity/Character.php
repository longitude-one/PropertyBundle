<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
use LongitudeOne\PropertyBundle\Entity\ExtendableTrait;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Entity\LinkedTrait;
use LongitudeOne\PropertyBundle\Tests\App\Repository\CharacterRepository;

#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: 'lopb_test_character')]
class Character implements ExtendableInterface, LinkedInterface
{
    use ExtendableTrait;
    use LinkedTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 31, nullable: false)]
    private string $name = '';

    public function __construct()
    {
        $this->initializeProperties();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLinkedId(): int
    {
        return $this->getId() ?? 0;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
