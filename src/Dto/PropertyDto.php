<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Dto;

use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;

class PropertyDto
{
    private FieldDto $fieldDto;
    private string $label;
    private string $name;
    private int $type;
    private mixed $value;

    public function getFieldDto(): FieldDto
    {
        return $this->fieldDto;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setFieldDto(FieldDto $fieldDto): self
    {
        $this->fieldDto = $fieldDto;

        return $this;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setValue(mixed $value): PropertyDto
    {
        $this->value = $value;

        return $this;
    }
}
