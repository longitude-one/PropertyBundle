<?php

namespace LongitudeOne\CookiesConsentBundle\Tests\App;

use Exception;
use JetBrains\PhpStorm\Pure;
use LongitudeOne\CookiesConsentBundle\CookiesConsentBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    #[Pure]
    public function registerBundles(): iterable
    {
        return [
            new FrameworkBundle(),
            new CookiesConsentBundle(),
        ];
    }

    /**
     * @throws Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config/config.yaml');
    }
}
