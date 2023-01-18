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

use JetBrains\PhpStorm\ArrayShape;
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
            $this->translator->trans('definition.type.boolean', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::BOOLEAN,
            $this->translator->trans('definition.type.integer', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::INTEGER,
            $this->translator->trans('definition.type.float', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::FLOAT,
            $this->translator->trans('definition.type.text', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::TEXT,
            $this->translator->trans('definition.type.mixed', [], 'LongitudeOnePropertyBundle') => DefinitionInterface::MIXED,
        ];
    }
}
