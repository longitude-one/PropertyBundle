<?php

namespace LongitudeOne\PropertyBundle\Controller;

use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method render(string $view, array $parameters = [], Response $response = null): Response
 */
trait PropertyControllerTrait
{
    private function renderExtendableEntities(PropertyService $propertyService): Response
    {
        return $this->render('@LongitudeOneProperty/easyadmin/entities-list.html.twig', [
            'entities' => $propertyService->getEntities(),
        ]);
    }
}