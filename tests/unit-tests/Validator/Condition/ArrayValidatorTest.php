<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Validator\Condition;


use BartoszBartniczak\ArrayObject\ArrayObject;
use BartoszBartniczak\EventSourcing\DBAL\Condition\Condition;
use BartoszBartniczak\EventSourcing\DBAL\Condition\ConditionsArray;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\Validator as ConditionValidator;
use BartoszBartniczak\EventSourcing\DBAL\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Validator as ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ArrayValidatorTest extends TestCase
{

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\ArrayValidator::validate
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\ArrayValidator::__construct
     */
    public function testValidate()
    {

        $conditionsArray = new ConditionsArray();
        $conditionsArray[] = new Condition('id=123', new ArrayObject());
        $conditionsArray[] = new Condition('id=?', new ArrayObject(['id' => 100]));

        $validator = new ArrayValidator(new ConditionValidator());
        $this->assertInstanceOf(ValidatorInterface::class, $validator);
        $this->assertTrue($validator->validate($conditionsArray));

    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\ArrayValidator::validate
     */
    public function testValidateAcceptsEmptyArrays()
    {

        $conditionsArray = new ConditionsArray();

        $validator = new ArrayValidator(new ConditionValidator());
        $this->assertInstanceOf(ValidatorInterface::class, $validator);
        $this->assertTrue($validator->validate($conditionsArray));

    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\ArrayValidator::validate
     */
    public function testValidateThrowsExceptionIfAtLeastOneOfConditionsIsInvalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Empty value. Value named 'id' is not set.");

        $conditionsArray = new ConditionsArray();
        $conditionsArray[] = new Condition('id=123', new ArrayObject());
        $conditionsArray[] = new Condition('id=?', new ArrayObject(['id' => null]));

        $conditionValidator = $this->getMockBuilder(ConditionValidator::class)
            ->setMethods([
                'validate'
            ])
            ->getMock();
        $conditionValidator->expects($this->at(0))
            ->method('validate')
            ->willReturn(true);
        $conditionValidator->expects($this->at(1))
            ->method('validate')
            ->willThrowException(new InvalidArgumentException('Empty value. Value named \'id\' is not set.'));

        /* @var $conditionValidator ConditionValidator */

        $validator = new ArrayValidator($conditionValidator);
        $validator->validate($conditionsArray);

    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\ArrayValidator::validate
     */
    public function testValidateThrowsExceptionIfDataIsNotAnObject()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected object type of '" . ConditionsArray::class . "', 'integer' given.");

        $validator = ArrayValidator::create();
        $validator->validate(123);
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\ArrayValidator::validate
     */
    public function testValidateThrowsExceptionIfDataIsNotInstanceOfConditionsArray()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected object type of '" . ConditionsArray::class . "', '" . \DateTime::class . "' given.");

        $validator = ArrayValidator::create();
        $validator->validate(new \DateTime());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\Condition\ArrayValidator::create
     */
    public function testCreate()
    {

        $this->assertEquals(new ArrayValidator(new Validator()), ArrayValidator::create());

    }

}
