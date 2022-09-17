<?php

namespace LongitudeOne\CookiesConsentBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class FooControllerTest extends WebTestCase
{
    private ?KernelBrowser $client = null;

    public function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function tearDown(): void
    {
        $this->client = null;
    }

    public function testBarAction()
    {
        $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}
