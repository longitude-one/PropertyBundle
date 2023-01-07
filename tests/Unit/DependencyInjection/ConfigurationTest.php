<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\Unit\DependencyInjection;

use LongitudeOne\PropertyBundle\LongitudeOnePropertyBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Yaml\Yaml;

class ConfigurationTest extends TestCase
{
    /**
     * @return array<string, mixed>
     */
    private static function process(string $content): array
    {
        $config = Yaml::parse($content);

        $configs = [$config];

        $processor = new Processor();
        $metaConfiguration = (new LongitudeOnePropertyBundle())
            ->getContainerExtension()
            ->getConfiguration([], new ContainerBuilder(new ParameterBag()))
        ;

        return $processor->processConfiguration(
            $metaConfiguration,
            $configs
        );
    }

    /**
     * @return array<string, mixed>
     */
    private static function processFile(string $filename): array
    {
        $file = __DIR__.'/../../Tools/config-samples/'.$filename;
        $content = file_get_contents($file);

        if (false === $content) {
            self::markTestIncomplete('This test seems to have been not implemented yet. Unable to read file: '.$file);
        }

        return self::process($content);
    }

    public function testEmptyConfiguration(): void
    {
        $metaArray = self::process('');
        self::assertSame($metaArray, [
            'extendable_entities' => [],
        ]);
    }

    public function testNoMoreValidConfiguration(): void
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('Invalid type for path "longitude_one_property.extendable_entities.0". Expected "array", but got "string"');

        self::processFile('config-no-more-valid.yaml');
    }

    public function testNonExtendableConfiguration(): void
    {
        $metaArray = self::processFile('config-non-extendable.yaml');
        self::assertSame($metaArray, [
            'extendable_entities' => [
                'empty' => [
                    'class' => 'LongitudeOne\PropertyBundle\Tests\Tools\EmptyTool',
                ],
                'tool' => [
                    'class' => 'LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity',
                ],
            ],
        ]);
    }

    public function testNonValidConfiguration(): void
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('Unrecognized option "foo" under "longitude_one_property.extendable_entities.tool');

        self::processFile('config-non-valid.yaml');
    }

    public function testValidConfiguration(): void
    {
        $metaArray = self::processFile('config-valid.yaml');
        self::assertSame($metaArray, [
            'extendable_entities' => [
                'tool' => [
                    'class' => 'LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity',
                ],
            ],
        ]);
    }
}
