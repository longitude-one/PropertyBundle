<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Controller;

use LongitudeOne\PropertyBundle\Service\PropertyContextService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method render(string $view, array $parameters = [], Response $response = null): Response
 */
trait PropertyControllerTrait
{
    private function renderExtendableEntities(PropertyContextService $service): Response
    {
        return $this->render('@LongitudeOneProperty/easyadmin/entities-list.html.twig', [
            'ea' => $service->getContext(),
            'entities' => $service->getEntities(),
        ]);
    }
}
