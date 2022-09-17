<?php


use LongitudeOne\CookiesConsentBundle\Controller\FooController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class FooControllerTest extends TestCase
{
    private ?FooController $controller = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new FooController();
    }

    protected function tearDown(): void
    {
        $this->controller = null;
        parent::tearDown();
    }

    public function testBarAction()
    {
        $this->assertInstanceOf(JsonResponse::class, $this->controller->barAction());
    }
}
