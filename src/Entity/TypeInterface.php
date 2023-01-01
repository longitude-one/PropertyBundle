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

use Symfony\Component\Form\FormTypeExtensionInterface;

interface TypeInterface
{
    public function getType(): FormTypeExtensionInterface;

    public function setType(FormTypeExtensionInterface $type): self;
}
