<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Entity;

interface PropertyInterface
{
    public function getValue(): bool|float|int|null|string;

    public function setValue(bool|float|int|null|string $value): self;

    public function getName(): string;

    public function setName(string $name): self;
}
