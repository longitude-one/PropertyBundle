<?php

/**
 * This file is part of the LongitudeOne/PropertyBundle
 *
 * PHP 8.1 | Symfony 6.1+
 *
 * Copyright LongitudeOne - Alexandre Tranchant
 * Copyright 2021 - 2023
 */

namespace LongitudeOne\PropertyBundle\Tests\Unit\Validator;

use LongitudeOne\PropertyBundle\Tests\Tools\EmptyTool;
use LongitudeOne\PropertyBundle\Validator\InstanceOfExtendableValidator;
use LongitudeOne\PropertyBundle\Validator\Keyword;
use LongitudeOne\PropertyBundle\Validator\KeywordValidator;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @extends ConstraintValidatorTestCase<InstanceOfExtendableValidator>
 */
class KeywordValidatorTest extends ConstraintValidatorTestCase
{
    public function testArrayThrowException(): void
    {
        self::expectExceptionMessage('Expected argument of type "string", "array" given');
        self::expectException(UnexpectedValueException::class);

        $this->validator->validate([], new Keyword());
    }

    public function testBadConstraintThrowException(): void
    {
        self::expectExceptionMessage('Expected argument of type "LongitudeOne\PropertyBundle\Validator\Keyword", "Symfony\Component\Validator\Constraints\Blank" given');
        self::expectException(UnexpectedTypeException::class);

        $this->validator->validate('', new Blank());
    }

    public function testEmptyIsValid(): void
    {
        $this->validator->validate('', new Keyword());

        self::assertNoViolation();
    }

    public function testEmptyToolIsValid(): void
    {
        $this->validator->validate(new EmptyTool(), new Keyword());

        self::assertNoViolation();
    }

    public function testKeywordsAreValid(): void
    {
        $this->validator->validate('example', new Keyword());
        $this->validator->validate('ex-aM-ple+', new Keyword());
        $this->validator->validate('ex_am-plE', new Keyword());
        $this->validator->validate('Ex_am-ple', new Keyword());

        self::assertNoViolation();
    }

    public function testNullIsValid(): void
    {
        $this->validator->validate(null, new Keyword());

        self::assertNoViolation();
    }

    public function testObjectThrowException(): void
    {
        self::expectExceptionMessage('Expected argument of type "string", "stdClass" given');
        self::expectException(UnexpectedValueException::class);

        $this->validator->validate(new \stdClass(), new Keyword());
    }

    public function testToolEntityIsValid(): void
    {
        $this->validator->validate(new EmptyTool(), new Keyword());

        self::assertNoViolation();
    }

    protected function createValidator(): KeywordValidator
    {
        return new KeywordValidator();
    }
}
