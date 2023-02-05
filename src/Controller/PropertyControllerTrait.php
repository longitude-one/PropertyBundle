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

use Doctrine\ORM\EntityManagerInterface;
use LongitudeOne\PropertyBundle\Entity\AbstractProperty;
use LongitudeOne\PropertyBundle\Service\PropertyContextService;
use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method render(string $view, array $parameters = [], Response $response = null): Response
 */
trait PropertyControllerTrait
{
    #[Route('/lopb_show/{keyword}', name: 'longitudeone_property_extendable_entities_show')]
    public function showExtendableEntity(PropertyService $propertyService, EntityManagerInterface $em, string $keyword): Response
    {
        $entityDefinition = $propertyService->getEntity($keyword);
        $repository = $em->getRepository(AbstractProperty::class);
        $properties = $repository->findByEntityClassName($entityDefinition['class']);
        //FIXME fix or remove this use case
        dd($properties);
    }

    #[Route('/lopb/list', name: 'longitudeone_property_extendable_entities_list')]
    public function listExtendableEntities(PropertyContextService $service): Response
    {
        return  $this->render('@LongitudeOneProperty/easyadmin/entities-list.html.twig', [
            'ea' => $service->getContext(),
            'entities' => $service->getEntities(),
        ]);
    }
}
