<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit;


use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\FindAll;
use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\Quantity as QuantityLimit;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\UnexpectedValueException;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Validator as ValidatorInterface;
use PHPUnit\Framework\TestCase;

class QuantityTest extends TestCase
{
    /**
     * @var Quantity
     */
    protected $validator;

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Quantity::validate
     */
    public function testValidate()
    {

        $this->assertInstanceOf(ValidatorInterface::class, $this->validator);
        $this->validator->validate(new QuantityLimit(123));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Quantity::validate
     */
    public function testValidateThrowsExceptionIfValueIsNotAnObject()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Object expected of type '" . QuantityLimit::class . "', 'integer' given.");

        $this->validator->validate(123);
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Quantity::validate
     */
    public function testValidateThrowsExceptionIfObjectIsNotInstanceOfQuantity()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Object expected of type '" . QuantityLimit::class . "', '" . FindAll::class . "' given.");

        $this->validator->validate(new FindAll());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Quantity::validate
     */
    public function testValidateThrowsExceptionIfValueIsLowerThanZero()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Quantity cannot be lower or equals to zero.');

        $this->validator->validate(new QuantityLimit(-1));
    }

    public function testValidateThrowsExceptionIfValueIsEqualsToZero()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Quantity cannot be lower or equals to zero.');

        $this->validator->validate(new QuantityLimit(0));
    }

    protected function setUp()
    {
        $this->validator = new Quantity();
    }

}
