<?php

namespace LongitudeOne\CookiesConsentBundle\Tests\Functional;

use LongitudeOne\CookiesConsentBundle\Tests\App\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as SymfonyWebTestCase;

abstract class WebTestCase extends SymfonyWebTestCase
{
    protected static function getKernelClass(): string
    {
        return AppKernel::class;
    }
}
