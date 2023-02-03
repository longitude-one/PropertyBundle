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

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use LongitudeOne\PropertyBundle\Entity\Definition;
use LongitudeOne\PropertyBundle\Service\DefinitionService;
use LongitudeOne\PropertyBundle\Service\PropertyService;
use Symfony\Component\Translation\TranslatableMessage;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefinitionCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly PropertyService $propertyService,
        private readonly DefinitionService $definitionService,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Definition::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::DELETE,
                fn (Action $action) => $action->displayIf(
                    fn (Definition $entity) => $entity->getProperties()->count() > 0
                )
            )
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(new TranslatableMessage('definition.label', [], 'LongitudeOnePropertyBundle'))
            ->setEntityLabelInPlural(new TranslatableMessage('definitions.label', [], 'LongitudeOnePropertyBundle'))

            ->setSearchFields(['name'])
            ->setDefaultSort(['name' => 'ASC', 'entityClassname' => 'ASC'])

            ->setPageTitle('index', new TranslatableMessage('definition.index.title', [], 'LongitudeOnePropertyBundle'))
            ->setPageTitle('edit', new TranslatableMessage('definition.edit.title', [], 'LongitudeOnePropertyBundle'))
            ->setPageTitle('new', new TranslatableMessage('definition.new.title', [], 'LongitudeOnePropertyBundle'))

            ->setHelp('index', new TranslatableMessage('definition.index.help', [], 'LongitudeOnePropertyBundle'))
            ->setHelp('edit', new TranslatableMessage('definition.edit.help', [], 'LongitudeOnePropertyBundle'))
            ->setHelp('new', new TranslatableMessage('definition.new.help', [], 'LongitudeOnePropertyBundle'))

            ->showEntityActionsInlined()

//            ->setFormOptions([
//                'validation_groups' => ['lopb_validation_groups']
//            ])
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()
                ->setHelp(new TranslatableMessage('definition.field.id.help', [], 'LongitudeOnePropertyBundle'))
                ->setLabel(new TranslatableMessage('definition.field.id.label', [], 'LongitudeOnePropertyBundle'))
                ->onlyOnDetail(),
            TextField::new('name')
                ->setMaxLength(31)
                ->setHelp(new TranslatableMessage('definition.field.name.help', [], 'LongitudeOnePropertyBundle'))
                ->setLabel(new TranslatableMessage('definition.field.name.label', [], 'LongitudeOnePropertyBundle')),
            ChoiceField::new('type')
                ->setHelp(new TranslatableMessage('definition.field.type.help', [], 'LongitudeOnePropertyBundle'))
                ->setLabel(new TranslatableMessage('definition.field.type.label', [], 'LongitudeOnePropertyBundle'))
                ->setChoices($this->definitionService->getChoices())
                ->hideWhenUpdating(),
            ChoiceField::new('entityClassname')
                ->setHelp(new TranslatableMessage('definition.field.entityClassname.help', [], 'LongitudeOnePropertyBundle'))
                ->setLabel(new TranslatableMessage('definition.field.entityClassname.label', [], 'LongitudeOnePropertyBundle'))
                ->setChoices($this->propertyService->getChoices())
                ->formatValue(fn (string $value) => 'lopb.keyword.' . $value)
                ->hideWhenUpdating(),
            BooleanField::new('enabled')
                ->setHelp(new TranslatableMessage('definition.field.enabled.help', [], 'LongitudeOnePropertyBundle'))
                ->setLabel(new TranslatableMessage('definition.field.enabled.label', [], 'LongitudeOnePropertyBundle')),
        ];
    }
}
