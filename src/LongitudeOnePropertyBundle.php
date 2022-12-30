<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LongitudeOnePropertyBundle extends AbstractBundle
{
    public const LO_PROPERTIES = 'longitude_one_property';

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
            ->arrayNode('extendable_entities')
            ->defaultValue([])
            ->scalarPrototype()->end()
            ->end()
            ->end()
            ->end();
    }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $loader = new PhpFileLoader($builder, new FileLocator(__DIR__.'/Resources/config/'));
        $loader->load('services.php');
        $container->services()
            ->get('longitude-one.property_bundle.property_service')
            ->arg(0, $config['extendable_entities']);
//        dump($container->services()->get('longitude-one.property_bundle.property_service'));
    }
}
