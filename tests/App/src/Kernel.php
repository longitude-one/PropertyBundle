<?php

namespace LongitudeOne\PropertyBundle\Tests\App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function getCacheDir(): string
    {
        return $this->getProjectDir().'/var/'.$this->environment.'/cache';
    }

    public function getLogDir(): string
    {
        return $this->getProjectDir().'/var/'.$this->environment.'/log';
    }
}
