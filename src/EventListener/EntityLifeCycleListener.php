<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\EventListener;

use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Form;

class EntityLifeCycleListener implements EventSubscriberInterface
{
    public function __construct(private readonly PropertyService $propertyService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterEntityDeletedEvent::class => 'beforeEntityDeletedEvent',
            AfterEntityUpdatedEvent::class => 'afterEntityUpdatedEvent',
            AfterEntityPersistedEvent::class => 'afterEntityPersistedEvent',
        ];
    }

    public function afterEntityPersistedEvent(AfterEntityPersistedEvent $event): void
    {
        // TODO use the form as soon as this feature is accepted: https://github.com/EasyCorp/EasyAdminBundle/issues/5587
    }

    public function afterEntityUpdatedEvent(AfterEntityUpdatedEvent $event): void
    {
        // TODO use the form as soon as this feature is accepted: https://github.com/EasyCorp/EasyAdminBundle/issues/5587
    }

    public function beforeEntityDeletedEvent(BeforeEntityDeletedEvent $event): void
    {
        // Delete all properties of this entity
        $this->propertyService->deleteAll($event->getEntityInstance(), false);
    }
}
