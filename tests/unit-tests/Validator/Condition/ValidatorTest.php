<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Validator\Condition;


use BartoszBartniczak\ArrayObject\ArrayObject;
use BartoszBartniczak\EventSourcing\DBAL\Condition\Condition;
use BartoszBartniczak\EventSourcing\DBAL\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Validator as ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\Validator::validate
     */
    public function testValidateAcceptsConditionWithEmptyParametersArray()
    {
        $validator = new Validator();
        $this->assertInstanceOf(ValidatorInterface::class, $validator);

        $this->assertTrue($validator->validate(new Condition('id=123', new ArrayObject())));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\Validator::validate
     */
    public function testValidateAcceptsConditionWithAllValuesSet()
    {
        $validator = new Validator();
        $this->assertTrue($validator->validate(new Condition('id=? and email=?', new ArrayObject([
            'id' => 123,
            'email' => 'test@user.com'
        ]))));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\Validator::validate
     */
    public function testValidateThrowsExceptionIfAtLeastOneValueIsNotSet()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Empty value. Value named 'email' is not set.");

        $validator = new Validator();
        $validator->validate(new Condition('id=? and email=?', new ArrayObject([
            'id' => 123,
            'email' => null
        ])));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\Validator::validate
     */
    public function testValidateThrowsExceptionIfDataIsNotAnObject()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected object type of '" . Condition::class . "', 'integer' given.");

        $validator = new Validator();
        $validator->validate(123);
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\Validator::validate
     */
    public function testValidateThrowsExceptionIfDataIsNotInstanceOfCondition()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected object type of '" . Condition::class . "', '" . \DateTime::class . "' given.");

        $validator = new Validator();
        $validator->validate(new \DateTime());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\Validator::validate
     */
    public function testValidateThrowsExceptionIfConditionIsEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Condition cannot be empty.");

        $validator = new Validator();
        $validator->validate(new Condition('', new ArrayObject()));
    }

}
