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

use LongitudeOne\PropertyBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Yaml\Yaml;

class ConfigurationTest extends TestCase
{
    public function testEmptyConfiguration(): void
    {
        $metaArray = $this->process('');
        self::assertSame($metaArray, [
            'extendable_entities' => [],
        ]);
    }

    public function testNonExtendableConfiguration(): void
    {
        $metaArray = $this->processFile('config-non-extendable.yaml');
        self::assertSame($metaArray, [
            'extendable_entities' => [
                'LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity',
                'LongitudeOne\PropertyBundle\Tests\Tools\EmptyTool',
            ],
        ]);
    }

    public function testNonValidConfiguration(): void
    {
        self::expectException(InvalidConfigurationException::class);
        self::expectExceptionMessage('Invalid type for path "longitude_one_property.extendable_entities.foo". Expected "scalar", but got "array".');

        $this->processFile('config-non-valid.yaml');
    }

    public function testValidConfiguration(): void
    {
        $metaArray = $this->processFile('config-valid.yaml');
        self::assertSame($metaArray, [
            'extendable_entities' => [
                'LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity',
            ],
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function process(string $content): array
    {
        $config = Yaml::parse($content);

        $configs = [$config];

        $processor = new Processor();
        $metaConfiguration = new Configuration();

        return $processor->processConfiguration(
            $metaConfiguration,
            $configs
        );
    }

    /**
     * @return array<string, mixed>
     */
    private function processFile(string $filename): array
    {
        $file = __DIR__.'/../../Tools/config-samples/'.$filename;
        $content = file_get_contents($file);

        if (false === $content) {
            self::markTestIncomplete('This test seems to have been not implemented yet. Unable to read file: '.$file);
        }

        return $this->process($content);
    }
}
