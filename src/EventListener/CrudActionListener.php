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
use LongitudeOne\PropertyBundle\Dto\PropertyDto;
use LongitudeOne\PropertyBundle\Entity\DefinitionInterface;
use LongitudeOne\PropertyBundle\Entity\ExtendableInterface;
use LongitudeOne\PropertyBundle\Entity\LinkedInterface;
use LongitudeOne\PropertyBundle\Service\DefinitionService;
use LongitudeOne\PropertyBundle\Service\PropertyService;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
        // FIXME remove the last test because if and only if entity implements ExtendableInterface, it is extendable.
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
        // FIXME remove the last test because if and only if entity implements ExtendableInterface, it is extendable.
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
        if ($instance instanceof ExtendableInterface) {
            // Get all properties for this entity. AdminContext is not null because of the first test.
            $instance->setProperties($this->propertyService->getAllProperties($instance));
        }

        return $instance;
    }

    private function completeForm(Form $form, PropertyDto $propertyDto): void
    {
        $form->add(
            $propertyDto->getName(),
            $this->getFormType($propertyDto->getType()),
            [
                // TODO complete options : "action", "allow_file_upload", "attr", "attr_translation_parameters", "auto_initialize", "block_name", "block_prefix", "by_reference", "compound", "data", "data_class", "disabled", "ea_crud_form", "empty_data", "error_bubbling", "form_attr", "getter", "help", "help_attr", "help_html", "help_translation_parameters", "inherit_data", "invalid_message", "invalid_message_parameters", "is_empty_callback", "label", "label_attr", "label_format", "label_html", "label_translation_parameters", "mapped", "method", "post_max_size_message", "priority", "property_path", "required", "row_attr", "setter", "translation_domain", "trim", "upload_max_size_message"
                'data' => $propertyDto->getValue(),
                'label' => $propertyDto->getLabel(),
                'mapped' => false,
                // TODO create an help description in the definition to allow admin to add a description to help the user
//                    'help' => $propertyDto->getHelp(),
                // TODO create some options in propertyDto and definition to allow admin to configure the field
//                    'required' => $propertyDto->isRequired(),
                'translation_domain' => 'messages', // FIXME use translation domain where element are set in database
                // TODO create a placeholder in the definition to allow admin to add a placeholder to help the user
//                    'attr' => [
//                        'placeholder' => $propertyDto->getPlaceholder(),
//                    ],
            ]
        );
    }

    private function getFormType(int $definitionType): string
    {
        return match ($definitionType) {
            DefinitionInterface::TYPE_INTEGER => IntegerType::class,
            DefinitionInterface::TYPE_FLOAT => NumberType::class,
            DefinitionInterface::TYPE_BOOLEAN => CheckboxType::class,
            default => TextType::class,
        };
    }

    private function getInstance(AdminContext $adminContext): object
    {
        return $adminContext->getEntity()->getInstance();
    }

    private function onDetailPage(AfterCrudActionEvent $event): void
    {
        // $event->getAdminContext() cannot be null because of the first test.
        $instance = $this->getInstance($event->getAdminContext());
        if (!$instance instanceof ExtendableInterface) {
            return;
        }

        $propertiesDto = $this->propertyService->getPropertiesDto($instance);
        $event->getResponseParameters()->set('properties', $propertiesDto);
    }

    private function onEditPage(AfterCrudActionEvent $event): void
    {
        /** @var Form $form */
        $form = $event->getResponseParameters()->get('edit_form');

        // TODO add a fieldset for our custom properties
        $instance = $this->getInstance($event->getAdminContext());
        if (!$instance instanceof ExtendableInterface) {
            return;
        }

        // put that in a service
        foreach ($this->propertyService->getPropertiesDto($instance) as $propertyDto) {
            $this->completeForm($form, $propertyDto);
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
        if ($instance instanceof LinkedInterface) {
            $this->completeExtandableEntity($instance);
        }

        if (!$instance instanceof ExtendableInterface) {
            return;
        }

        foreach ($this->propertyService->getPropertiesDto($instance) as $propertyDto) {
            $this->completeForm($form, $propertyDto);
        }
    }
}
