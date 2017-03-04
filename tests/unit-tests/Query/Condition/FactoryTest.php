<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Condition;


use BartoszBartniczak\ArrayObject\ArrayObject;
use BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory;
use BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::fromString
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::parseCondition
     */
    public function testFromStringWithoutParameter()
    {

        $factory = new Factory();

        $this->assertEquals(new Condition('id=123', new ArrayObject()), $factory->fromString('id=123'));

    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::fromString
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::parseCondition
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::countUnnamedParameters
     */
    public function testFromStringWithOneUnnamedParameter()
    {

        $factory = new Factory();

        $this->assertEquals(new Condition('id=?', new ArrayObject([0 => null])), $factory->fromString('id=?'));

    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::fromString
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::parseCondition
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::countUnnamedParameters
     */
    public function testFromStringWithTwoOrMoreUnnamedParameters()
    {

        $factory = new Factory();

        $this->assertEquals(new Condition('id=? and email=?', new ArrayObject([0 => null, 1 => null])), $factory->fromString('id=? and email=?'));
        $this->assertEquals(new Condition('id=? and email=? and password=?', new ArrayObject([0 => null, 1 => null, 2 => null])), $factory->fromString('id=? and email=? and password=?'));

    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::fromString
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::parseCondition
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::findNamedParameters
     */
    public function testFromStringWithOneNamedParameter()
    {

        $factory = new Factory();

        $this->assertEquals(new Condition('id=:id', new ArrayObject(['id' => null])), $factory->fromString('id=:id'));

    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::fromString
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::parseCondition
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::findNamedParameters
     */
    public function testFromStringWithTwoOrMoreNamedParameters()
    {
        $factory = new Factory();

        $this->assertEquals(new Condition('id=:id and email=:email', new ArrayObject(['id' => null, 'email' => null])), $factory->fromString('id=:id and email=:email'));

        $this->assertEquals(new Condition('id=:id and email=:email and password=:password', new ArrayObject(['id' => null, 'email' => null, 'password' => null])), $factory->fromString('id=:id and email=:email and password=:password'));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory::parseCondition
     */
    public function testParseConditionThrowsInvalidArgumentExceptionIfConditionContainsBothUnnamedAndNamedParameters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Condition contains both: unnamed and named parameters. Cannot parse this condition.');

        $factory = new Factory();
        $factory->fromString('id = ? and email = :email');

    }


}
