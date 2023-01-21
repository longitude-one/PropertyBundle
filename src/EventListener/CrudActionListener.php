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

use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\AssetsDto;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use JetBrains\PhpStorm\ArrayShape;
use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
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

    #[ArrayShape([AfterCrudActionEvent::class => 'string', BeforeCrudActionEvent::class => 'string'])]
    public static function getSubscribedEvents(): array
    {
        return [
            AfterCrudActionEvent::class => 'afterCrudActionEvent',
            BeforeCrudActionEvent::class => 'beforeCrudActionEvent',
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

    public function beforeCrudActionEvent(BeforeCrudActionEvent $event): void
    {
    }

    protected function getFieldAssets(AfterCrudActionEvent $event, FieldCollection $fieldDtos): AssetsDto
    {
        $fieldAssetsDto = new AssetsDto();
        $currentPageName = $event->getAdminContext()?->getCrud()?->getCurrentPage();
        foreach ($fieldDtos as $fieldDto) {
            $fieldAssetsDto = $fieldAssetsDto->mergeWith($fieldDto->getAssets()->loadedOn($currentPageName));
        }

        return $fieldAssetsDto;
    }

    private function initInstance(AfterCrudActionEvent $event): ExtendableInterface
    {
        // Get all properties for this entity. AdminContext is not null because of the first test.
        $instance = $event->getAdminContext()->getEntity()->getInstance();
        $instance->setProperties($this->propertyService->getProperties($instance));

        return $instance;
    }

    private function onDetailPage(AfterCrudActionEvent $event): void
    {
        $instance = $this->initInstance($event);

        foreach ($instance->getProperties() as $property) {
            $this->logger->debug('PropertyBundle: Property found: '.$property->getDefinition()->getName().': '.$property->getValue());
        }

        $propertiesDto = $this->propertyService->getPropertiesDto($instance);
        $event->getResponseParameters()->set('lopb.properties', $propertiesDto);
    }

    private function onEditPage(AfterCrudActionEvent $event): void
    {
        $instance = $this->initInstance($event);

        /** @var Form $form */
        $form = $event->getResponseParameters()->get('edit_form');

        // TODO add a fieldset for our custom properties
        foreach ($this->propertyService->getPropertiesDto($instance) as $propertyDto) {
            // FIXME replace TextType::class by a more precise class
            $form->add($propertyDto->getName(), TextType::class, ['mapped' => false]);
        }
    }

    private function onIndexPage(AfterCrudActionEvent $event): void
    {
        $this->logger->debug('EasyAdmin Crud Index Page intercepted for properties');
    }

    private function onNewPage(AfterCrudActionEvent $event): void
    {
        $this->logger->debug('EasyAdmin Crud NEW Page intercepted for properties');
    }
}
