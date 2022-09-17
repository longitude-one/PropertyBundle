<?php

namespace LongitudeOne\CookiesConsentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CookiesConsentBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
