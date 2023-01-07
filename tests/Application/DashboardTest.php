<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\Application;

use LongitudeOne\PropertyBundle\Tests\App\Entity\Character;
use LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity;

class DashboardTest extends AppTestCase
{
    public function testDashboardAvailable(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $client->request('GET', '/admin');

        if ($client->getResponse()->isRedirection()) {
            $client->followRedirect();
        }

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('a', 'PropertyBundle Dashboard Tests');
    }

    public function testEntitiesList(): void
    {
        $client = static::createClient();
        $client->request('GET', '/admin/?routeName=longitudeone_property_tests_app_admin_dashboard_list');

        if ($client->getResponse()->isRedirection()) {
            $client->followRedirect();
        }

        // Validate a successful response and that our extendable entities are listed
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', ToolEntity::class);
        $this->assertSelectorTextContains('body', Character::class);
    }
}
