<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Parameter;


use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Parameter\Factory::createString
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Parameter\Factory::create
     */
    public function testCreateString()
    {

        $factory = new Factory();

        $this->assertEquals(new StringParameter('abc'), $factory->create(Parameter::TYPE_STRING, 'abc'));
        $this->assertEquals(new StringParameter('123'), $factory->create(Parameter::TYPE_STRING, 123));

    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Parameter\Factory::createInteger
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Parameter\Factory::create
     */
    public function testCreateInteger()
    {

        $factory = new Factory();

        $this->assertEquals(new IntegerParameter(123), $factory->create(Parameter::TYPE_INT, 123));
        $this->assertEquals(new IntegerParameter(123), $factory->create(Parameter::TYPE_INT, '123'));
    }

}
