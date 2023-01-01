<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Service;

use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;

class PropertyContextService
{
    private AdminContextProvider $adminContextProvider;
    private PropertyService $propertyService;

    public function __construct(AdminContextProvider $adminContextProvider, PropertyService $propertyService)
    {
        $this->adminContextProvider = $adminContextProvider;
        $this->propertyService = $propertyService;
    }

    public function getContext(): ?AdminContext
    {
        return $this->adminContextProvider->getContext();
    }

    /**
     * @return string[] entities full class name
     */
    public function getEntities(): array
    {
        return $this->propertyService->getEntities();
    }
}
