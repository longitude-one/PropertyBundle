<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2022
 */

namespace LongitudeOne\PropertyBundle\Tests\Unit\Validator;

use LongitudeOne\PropertyBundle\Tests\Tools\EmptyTool;
use LongitudeOne\PropertyBundle\Tests\Tools\ToolEntity;
use LongitudeOne\PropertyBundle\Validator\InstanceOfExtendable;
use LongitudeOne\PropertyBundle\Validator\InstanceOfExtendableValidator;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<InstanceOfExtendableValidator>
 */
class InstanceOfExtendableValidatorTest extends ConstraintValidatorTestCase
{
    public function testBadConstraintThrowException(): void
    {
        self::expectExceptionMessage('Expected argument of type "LongitudeOne\PropertyBundle\Validator\InstanceOfExtendable", "Symfony\Component\Validator\Constraints\Blank" given');
        self::expectException('Symfony\Component\Validator\Exception\UnexpectedTypeException');

        $this->validator->validate('', new Blank());
    }

    public function testEmptyIsNotValid(): void
    {
        self::expectExceptionMessage('Expected argument of type "object", "string" given');
        self::expectException('Symfony\Component\Validator\Exception\UnexpectedTypeException');

        $this->validator->validate('', new InstanceOfExtendable());
    }

    public function testEmptyToolIsNotValid(): void
    {
        $this->validator->validate(new EmptyTool(), new InstanceOfExtendable());

        self::buildViolation('The "{{ class }}" entity cannot be customize. Did you forget to implement  the ExtendableInterface?')
            ->setParameter('{{ class }}', EmptyTool::class)
            ->assertRaised();
    }

    public function testNullIsNotValid(): void
    {
        self::expectExceptionMessage('Expected argument of type "object", "null" given');
        self::expectException('Symfony\Component\Validator\Exception\UnexpectedTypeException');

        $this->validator->validate(null, new InstanceOfExtendable());
    }

    public function testToolEntityIsValid(): void
    {
        $this->validator->validate(new ToolEntity(), new InstanceOfExtendable());

        self::assertNoViolation();
    }

    protected function createValidator(): InstanceOfExtendableValidator
    {
        return new InstanceOfExtendableValidator();
    }
}
