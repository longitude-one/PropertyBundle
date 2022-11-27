<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\DependencyInjection\Loader\Configurator;

use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;

// use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container) {
    $container->services()
        ->set('longitude-one.property.service', PropertyService::class)
        ->args([
            param('extendable_entities'),
        ])
//        ->set('longitude-one.meta.twig-extension', MetaExtension::class)
//        ->args([service('longitude-one.meta.service')])
//        ->tag('twig.extension')
    ;
};
