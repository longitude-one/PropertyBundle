<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Service;

use LongitudeOne\PropertyBundle\Entity\DefinitionInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DefinitionService
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    /**
     * @return array<string, int>
     */
    public function getChoices(): array
    {
        return [
            $this->translator->trans('definition.type.boolean', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::TYPE_BOOLEAN,
            $this->translator->trans('definition.type.integer', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::TYPE_INTEGER,
            $this->translator->trans('definition.type.float', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::TYPE_FLOAT,
            $this->translator->trans('definition.type.text', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::TYPE_TEXT,
            $this->translator->trans('definition.type.mixed', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::TYPE_MIXED,
        ];
    }
}
