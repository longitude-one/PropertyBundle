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
use Symfony\Contracts\Translation\TranslatorInterface;

class DefinitionCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly TranslatorInterface $translator,
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
            ->setEntityLabelInSingular($this->trans('lopb.definition.label'))
            ->setEntityLabelInPlural($this->trans('lopb.definitions.label'))

            ->setSearchFields(['name'])
            ->setDefaultSort(['name' => 'ASC', 'entityClassname' => 'ASC'])

            ->setPageTitle('index', $this->trans('lopb.definition.index.title'))
            ->setPageTitle('edit', $this->trans('lopb.definition.edit.title'))
            ->setPageTitle('new', $this->trans('lopb.definition.new.title'))

            ->setHelp('index', $this->trans('lopb.definition.index.help'))
            ->setHelp('edit', $this->trans('lopb.definition.edit.help'))
            ->setHelp('new', $this->trans('lopb.definition.new.help'))

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
                ->setHelp('lopb.definition.field.id.help')
                ->setLabel('lopb.definition.field.id.label')
                ->onlyOnDetail(),
            TextField::new('name')
                ->setMaxLength(31)
                ->setHelp('lopb.definition.field.name.help')
                ->setLabel('lopb.definition.field.name.label'),
            ChoiceField::new('type')
                ->setHelp('lopb.definition.field.entityClassname.help')
                ->setLabel('lopb.definition.field.entityClassname.label')
                ->setChoices($this->definitionService->getChoices())
                ->hideWhenUpdating(),
            ChoiceField::new('entityClassname')
                ->setHelp('lopb.definition.field.entityClassname.help')
                ->setLabel('lopb.definition.field.entityClassname.label')
                ->setChoices($this->propertyService->getChoices())
                ->hideWhenUpdating(),
            BooleanField::new('enabled')
                ->setHelp('lopb.definition.field.enabled.help')
                ->setLabel('lopb.definition.field.enabled.label'),
        ];
    }

    /**
     * Simple shortcut.
     */
    private function trans(string $id): string
    {
        return $this->translator->trans($id, [], 'LongitudeOnePropertyBundle');
    }
}
