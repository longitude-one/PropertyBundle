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

interface PropertyInterface
{
    public function getDefinition(): DefinitionInterface;

    public function getEntityId(): int;

    public function getValue(): bool|float|int|null|string;

    public function setDefinition(DefinitionInterface $definition): self;

    public function setEntity(LinkedInterface $linkedEntity): self;

    public function setValue(bool|float|int|null|string $value): self;
}
