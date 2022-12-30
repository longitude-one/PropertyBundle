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

use LongitudeOne\PropertyBundle\Exception\ClassNotFoundException;

class PropertyService
{
    /**
     * @var string[] list of all extendable classes
     */
    private array $classes = [];

    /**
     * @param string[] $classes list of all extendable classes
     */
    public function __construct(array $classes)
    {
        dd($classes);
        foreach ($classes as $class) {
            if (!class_exists($class)) {
                throw new ClassNotFoundException('Class "'.$class.'" not found !');
            }
        }

        $this->classes = $classes;
    }

    /**
     * @return string[] $classes list of all extendable classes
     */
    public function getClasses(): array
    {
        return $this->classes;
    }
}
