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

use LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\Client;

class DashboardTest extends TestCase
{
    public function testDashboardAvailable(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a "client" that is acting as the browser
        // FIXME replace this string with some app environment variable
        $client = Client::createSeleniumClient('http://127.0.0.1:8000/');

        // Request a specific page
        $client->request('GET', 'admin');

        if ($client->getResponse()->isRedirection()) {
            $client->followRedirect();
        }

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('a', 'PropertyBundle Dashboard Tests');
    }

    public function testEntitiesList(): void
    {
        // FIXME replace this string with some app environment variable
        $client = Client::createSeleniumClient('http://127.0.0.1:8000/');
        $client->request('GET', '/admin/?routeName=longitudeone_property_tests_app_admin_dashboard_list');

        if ($client->getResponse()->isRedirection()) {
            $client->followRedirect();
        }

        // Validate a successful response and that our extendable entities are listed
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', ToolEntity::class);
    }
}
