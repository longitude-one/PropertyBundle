<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Service;

use LongitudeOne\PropertyBundle\Exception\EntityNotFoundException;

class PropertyService
{
    /**
     * @var string[] list of all extendable classes
     */
    private array $entities = [];

    /**
     * @param string[] $entities list of all extendable classes
     */
    public function __construct(array $entities)
    {
        foreach ($entities as $entity) {
            if (!class_exists($entity)) {
                throw new EntityNotFoundException('Entity "'.$entity.'" not found! Did you misspell your entity in the config/properties.yaml file?');
            }
        }

        $this->entities = $entities;
    }

    /**
     * @return string[] $classes list of all extendable classes
     */
    public function getEntities(): array
    {
        return $this->entities;
    }
}
