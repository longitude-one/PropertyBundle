<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Tests\App\Controller;

use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// FIXME remove this file
class FooController extends AbstractController
{
    #[Route('/foo', name: 'foo')]
    public function list(PropertyService $propertyService): Response
    {
        dd($propertyService);
    }
}
