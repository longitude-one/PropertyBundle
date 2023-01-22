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

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Service\DefinitionService;
use LongitudeOne\PropertyBundle\Service\PropertyService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;

class CrudActionListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly PropertyService $propertyService,
        private readonly DefinitionService $definitionService,
        private readonly LoggerInterface $logger,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AfterCrudActionEvent::class => 'afterCrudActionEvent',
            BeforeCrudActionEvent::class => 'beforeCrudActionEvent',
            AfterEntityDeletedEvent::class => 'beforeEntityDeletedEvent',
            AfterEntityUpdatedEvent::class => 'afterEntityUpdatedEvent',
            AfterEntityPersistedEvent::class => 'afterEntityPersistedEvent',
        ];
    }

    public function afterCrudActionEvent(AfterCrudActionEvent $event): void
    {
        // Is extendable entity declared?
        if (null === $event->getAdminContext() || !$this->propertyService->has($event->getAdminContext()->getEntity()->getFqcn())) {
            return;
        }

        if ($event->isPropagationStopped()) {
            return;
        }

        if (!$event->getResponseParameters()->has('pageName')) {
            $this->logger->warning('pageName is not present in response parameters of this instance of AfterCrudActionEvent');

            return;
        }

        // Let's call the method
        match ($event->getResponseParameters()->get('pageName')) {
            Crud::PAGE_DETAIL => $this->onDetailPage($event),
            Crud::PAGE_EDIT => $this->onEditPage($event),
            Crud::PAGE_NEW => $this->onNewPage($event),
            // Crud::PAGE_INDEX => onIndexPage($event),
            default => $this->onIndexPage($event),
        };
    }

    public function afterEntityPersistedEvent(AfterEntityPersistedEvent $event): void
    {
        // TODO use the form as soon as this feature is accepted: https://github.com/EasyCorp/EasyAdminBundle/issues/5587
    }

    public function afterEntityUpdatedEvent(AfterEntityUpdatedEvent $event): void
    {
        // TODO use the form as soon as this feature is accepted: https://github.com/EasyCorp/EasyAdminBundle/issues/5587
    }

    public function beforeCrudActionEvent(BeforeCrudActionEvent $event): void
    {
        // Is extendable entity declared?
        if (null === $event->getAdminContext() || !$this->propertyService->has($event->getAdminContext()->getEntity()->getFqcn())) {
            return;
        }

        if ($event->isPropagationStopped()) {
            return;
        }

        if (!$event->getAdminContext()->getEntity()->isAccessible()) {
            return;
        }

        $instance = $event->getAdminContext()->getEntity()->getInstance();
        if (!$instance instanceof ExtendableInterface || !$instance instanceof LinkedInterface) {
            return;
        }

        $this->completeExtandableEntity($instance);
    }

    public function beforeEntityDeletedEvent(BeforeEntityDeletedEvent $event): void
    {
        // Delete all properties of this entity
        $this->propertyService->deleteAll($event->getEntityInstance(), false);
    }

    private function completeExtandableEntity(LinkedInterface $instance): LinkedInterface
    {
        // Get all properties for this entity. AdminContext is not null because of the first test.
        $instance->setProperties($this->propertyService->getAllProperties($instance));

        return $instance;
    }

    private function getInstance(AdminContext $adminContext): ExtendableInterface
    {
        return $adminContext->getEntity()->getInstance();
    }

    private function onDetailPage(AfterCrudActionEvent $event): void
    {
        $propertiesDto = $this->propertyService->getPropertiesDto($this->getInstance($event->getAdminContext()));
        $event->getResponseParameters()->set('lopb.properties', $propertiesDto);
    }

    private function onEditPage(AfterCrudActionEvent $event): void
    {
        /** @var Form $form */
        $form = $event->getResponseParameters()->get('edit_form');

        // TODO add a fieldset for our custom properties
        $instance = $this->getInstance($event->getAdminContext());
        foreach ($this->propertyService->getPropertiesDto($instance) as $propertyDto) {
            // FIXME replace TextType::class by a more precise class
            // TODO complete options
            $form->add($propertyDto->getName(), TextType::class, ['mapped' => false]);
        }
    }

    private function onIndexPage(AfterCrudActionEvent $event): void
    {
        $this->logger->debug('EasyAdmin Crud Index Page intercepted for properties');
    }

    private function onNewPage(AfterCrudActionEvent $event): void
    {
        /** @var Form $form */
        $form = $event->getResponseParameters()->get('new_form');

        // TODO add a fieldset for our custom properties
        $instance = $this->getInstance($event->getAdminContext());
        $this->completeExtandableEntity($instance);
        foreach ($this->propertyService->getPropertiesDto($instance) as $propertyDto) {
            // FIXME replace TextType::class by a more precise class
            // TODO complete options
            $form->add($propertyDto->getName(), TextType::class, ['mapped' => false]);
        }
    }
}
