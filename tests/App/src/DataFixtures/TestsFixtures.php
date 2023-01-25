<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use LongitudeOne\PropertyBundle\Entity\BooleanProperty;
use LongitudeOne\PropertyBundle\Entity\Definition;
use LongitudeOne\PropertyBundle\Entity\DefinitionInterface;
use LongitudeOne\PropertyBundle\Entity\FloatProperty;
use LongitudeOne\PropertyBundle\Entity\IntegerProperty;
use LongitudeOne\PropertyBundle\Entity\NonTypedProperty;
use LongitudeOne\PropertyBundle\Entity\StringProperty;
use LongitudeOne\PropertyBundle\Tests\App\Entity\Character;

class TestsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $conan = new Character();
        $conan->setName('Conan');
        $manager->persist($conan);

        $electra = new Character();
        $electra->setName('Electra');
        $manager->persist($electra);

        $gandalf = new Character();
        $gandalf->setName('Gandalf');
        $manager->persist($gandalf);

        $lukeSkywalker = new Character();
        $lukeSkywalker->setName('Luke Skywalker');
        $manager->persist($lukeSkywalker);

        $ageDefinition = new Definition();
        $ageDefinition->setName('Age');
        $ageDefinition->setType(DefinitionInterface::TYPE_INTEGER);
        $ageDefinition->setEntityClassname(Character::class);
        $manager->persist($ageDefinition);

        $movieDefinition = new Definition();
        $movieDefinition->setName('Movie');
        $movieDefinition->setType(DefinitionInterface::TYPE_TEXT);
        $movieDefinition->setEntityClassname(Character::class);
        $manager->persist($movieDefinition);

        $aliveDefinition = new Definition();
        $aliveDefinition->setName('Alive');
        $aliveDefinition->setType(DefinitionInterface::TYPE_BOOLEAN);
        $aliveDefinition->setEntityClassname(Character::class);
        $manager->persist($aliveDefinition);

        $moneyDefinition = new Definition();
        $moneyDefinition->setName('Money');
        $moneyDefinition->setType(DefinitionInterface::TYPE_FLOAT);
        $moneyDefinition->setEntityClassname(Character::class);
        $manager->persist($moneyDefinition);

        $inventoryDefinition = new Definition();
        $inventoryDefinition->setName('Inventory');
        $inventoryDefinition->setType(DefinitionInterface::TYPE_MIXED);
        $inventoryDefinition->setEntityClassname(Character::class);
        $manager->persist($inventoryDefinition);
        $manager->flush();

        // Ages of characters
        $ages = [
            32 => $conan,
            28 => $electra,
            2019 => $gandalf,
            19 => $lukeSkywalker,
        ];

        foreach ($ages as $age => $character) {
            $ageProperty = new IntegerProperty($ageDefinition);
            $ageProperty->setEntity($character);
            $ageProperty->setValue($age);
            $manager->persist($ageProperty);
        }

        // Movies of characters
        $movies = [
            'Conan' => $conan,
            'Electra' => $electra,
            'The Lord of the Rings' => $gandalf,
            'Star Wars' => $lukeSkywalker,
        ];

        foreach ($movies as $movie => $character) {
            $movieProperty = new StringProperty($movieDefinition);
            $movieProperty->setEntity($character);
            $movieProperty->setValue($movie);
            $manager->persist($movieProperty);
        }

        $alives = [
            1 => $conan,
            0 => $electra,
            2 => $gandalf,
            3 => $lukeSkywalker,
        ];

        foreach ($alives as $alive => $character) {
            $aliveProperty = new BooleanProperty($aliveDefinition);
            $aliveProperty->setEntity($character);
            $aliveProperty->setValue($alive);
            $manager->persist($aliveProperty);
        }

        // Money of characters
        $monies = [
            '3.14' => $conan,
            '2.71' => $electra,
            '1.618' => $gandalf,
            '1.414' => $lukeSkywalker,
        ];

        foreach ($monies as $money => $character) {
            $moneyProperty = new FloatProperty($moneyDefinition);
            $moneyProperty->setEntity($character);
            $moneyProperty->setValue($money);
            $manager->persist($moneyProperty);
        }

        $inventories = [
            'sword and shield' => $conan,
            false => $electra,
            1 => $gandalf,
            42.0 => $lukeSkywalker,
        ];

        foreach ($inventories as $inventory => $character) {
            $inventoryProperty = new NonTypedProperty($inventoryDefinition);
            $inventoryProperty->setEntity($character);
            $inventoryProperty->setValue($inventory);
            $manager->persist($inventoryProperty);
        }

        $manager->flush();
    }
}
