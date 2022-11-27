<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public const LO_PROPERTIES = 'longitude_one_property';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::LO_PROPERTIES);

        $treeBuilder->getRootNode()->children()
            ->arrayNode('extendable_entities')
                ->defaultValue([])
                    ->scalarPrototype()->end()
                ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
