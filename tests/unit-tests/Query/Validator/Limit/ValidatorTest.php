<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit;


use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\FindAll;
use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\Limit;
use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\Quantity as QuantityLimit;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\UnexpectedValueException;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Validator as ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Validator::__construct
     */
    public function testConstructor()
    {
        $validator = new Validator(new Quantity());
        $this->assertInstanceOf(ValidatorInterface::class, $validator);
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Validator::create
     */
    public function testCreate()
    {
        $validator = Validator::create();
        $this->assertEquals(new Validator(new Quantity()), $validator);
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Validator::validate
     */
    public function testValidateQuantity()
    {

        $quantity = $this->getMockBuilder(Quantity::class)
            ->disableOriginalConstructor()
            ->setMethods([
                'validate'
            ])
            ->getMock();
        $quantity->expects($this->once())
            ->method('validate')
            ->willReturn(true);
        /* @var $quantity Quantity */

        $validator = new Validator($quantity);
        $this->assertTrue($validator->validate(new QuantityLimit(123)));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Validator::validate
     */
    public function testValidateFindAll()
    {
        $validator = Validator::create();
        $this->assertTrue($validator->validate(new FindAll()));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Validator::validate
     */
    public function testValidateThrowsExceptionIfDataIsNotAnObject()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected object type of '" . Limit::class . "', 'integer' given");

        $validator = Validator::create();
        $validator->validate(123);
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Validator::validate
     */
    public function testValidateThrowsExceptionIfDataIsNotInstanceOfLimit()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected object type of '" . Limit::class . "', '" . \DateTime::class . "' given");

        $validator = Validator::create();
        $validator->validate(new \DateTime());
    }

    public function testValidateThrowsExceptionIfObjectIsUnknownType()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Unknown type of object.');

        $limit = $this->getMockBuilder(Limit::class)
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        /* @var $limit Limit */

        $validator = Validator::create();
        $validator->validate($limit);
    }

}
