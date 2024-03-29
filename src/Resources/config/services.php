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
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use LongitudeOne\PropertyBundle\Controller\DefinitionCrudController;
use LongitudeOne\PropertyBundle\EventListener\CrudActionListener;
use LongitudeOne\PropertyBundle\EventListener\EntityLifeCycleListener;
use LongitudeOne\PropertyBundle\Repository\BooleanPropertyRepository;
use LongitudeOne\PropertyBundle\Repository\DefinitionRepository;
use LongitudeOne\PropertyBundle\Repository\FloatPropertyRepository;
use LongitudeOne\PropertyBundle\Repository\IntegerPropertyRepository;
use LongitudeOne\PropertyBundle\Repository\NonTypedPropertyRepository;
use LongitudeOne\PropertyBundle\Repository\PropertyRepository;
use LongitudeOne\PropertyBundle\Repository\StringPropertyRepository;
use LongitudeOne\PropertyBundle\Service\DefinitionService;
use LongitudeOne\PropertyBundle\Service\PropertyContextService;
use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

use Symfony\Component\DependencyInjection\Reference;

return static function (ContainerConfigurator $container) {
    // Repositories
    $repositories = [
        BooleanPropertyRepository::class,
        DefinitionRepository::class,
        FloatPropertyRepository::class,
        IntegerPropertyRepository::class,
        NonTypedPropertyRepository::class,
        PropertyRepository::class,
        StringPropertyRepository::class,
    ];

    foreach ($repositories as $repository) {
        $container->services()
            ->set($repository)
            ->arg(0, service(ManagerRegistry::class))
            ->tag('doctrine.repository_service')
        ;
    }

    // Public services
    $container->services()
        ->set(DefinitionService::class)
        ->autowire()
        ->public()
        ->arg(0, service('translator'))
    ;

    $container->services()
        ->set(PropertyService::class)
        ->autowire()
        ->public()
        ->arg(0, service('doctrine.orm.entity_manager'))
        ->arg(1, []) // param('extendable_entities') is not available yet. This argument will be replaced by extension.
    ;

    // Subscribers
    $container->services()
        ->set(CrudActionListener::class)
        ->arg(0, service(PropertyService::class))
        ->arg(1, service(DefinitionService::class))
        ->arg(2, new Reference('logger'))
        ->tag('kernel.event_listener', ['event' => AfterCrudActionEvent::class, 'method' => 'afterCrudActionEvent'])
        ->tag('kernel.event_listener', ['event' => BeforeCrudActionEvent::class, 'method' => 'beforeCrudActionEvent'])
    ;

    $container->services()
        ->set(EntityLifeCycleListener::class)
        ->arg(0, service(PropertyService::class))
        ->tag('kernel.event_listener', ['event' => BeforeEntityDeletedEvent::class, 'method' => 'beforeEntityDeletedEvent'])
        ->tag('kernel.event_listener', ['event' => AfterEntityUpdatedEvent::class, 'method' => 'afterEntityUpdatedEvent'])
        ->tag('kernel.event_listener', ['event' => AfterEntityPersistedEvent::class, 'method' => 'afterEntityPersistedEvent'])
    ;

    // CRUD Controllers
    $container->services()
        ->set(DefinitionCrudController::class)
        ->autowire()
        ->autoconfigure()
        ->public()
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
