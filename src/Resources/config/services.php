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

use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use LongitudeOne\PropertyBundle\Repository\BoolPropertyRepository;
use LongitudeOne\PropertyBundle\Repository\FloatPropertyRepository;
use LongitudeOne\PropertyBundle\Repository\IntegerPropertyRepository;
use LongitudeOne\PropertyBundle\Repository\NonTypedPropertyRepository;
use LongitudeOne\PropertyBundle\Repository\StringPropertyRepository;
use LongitudeOne\PropertyBundle\Service\PropertyContextService;
use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

// use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container) {
    $repositories = [
        BoolPropertyRepository::class,
        FloatPropertyRepository::class,
        IntegerPropertyRepository::class,
        NonTypedPropertyRepository::class,
        StringPropertyRepository::class,
    ];

    foreach ($repositories as $repository) {
        $container->services()
            ->set($repository)
            ->arg(0, service(ManagerRegistry::class))
            ->tag('doctrine.repository_service')
        ;
    }

    $container->services()
        ->set(PropertyService::class)
        ->autowire()
        ->public()
        ->arg(0, service('doctrine.orm.entity_manager'))
        ->arg(1, []) // param('extendable_entities') is not available yet. This argument will be replaced by extension.
    ;

    // TODO Find a way to tell devs that PropertyContextService is only available when easy admin bundle is included.
    if (class_exists(AdminContextProvider::class)) {
        $container->services()
            ->set(PropertyContextService::class)
            ->public()
            ->arg(0, service(AdminContextProvider::class))
            ->arg(1, service(PropertyService::class))
        ;
    }
};
