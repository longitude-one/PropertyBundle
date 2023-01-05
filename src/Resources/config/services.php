<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\DependencyInjection\Loader\Configurator;

use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use LongitudeOne\PropertyBundle\Service\PropertyContextService;
use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

// use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set(PropertyService::class)
        ->public()
        ->arg(0, []) // param('extendable_entities') is not available yet. This argument will be replaced by extension.
        ->public()
    ;

    // TODO Find a way to tell devs that PropertyContextService is only available when easy admin bundle is included.
    if (class_exists(AdminContextProvider::class)) {
        $container->services()
            ->set(PropertyContextService::class)
            ->public()
            ->arg(0, service(AdminContextProvider::class))
            ->arg(1, service(PropertyService::class))
            ->public()
        ;
    }
};
