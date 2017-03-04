<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query;


use BartoszBartniczak\ArrayObject\ArrayObject;
use BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition;
use BartoszBartniczak\EventSourcing\DBAL\Query\Condition\ConditionsArray;
use BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Factory\Factory;
use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\FindAll;
use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\Quantity;
use BartoszBartniczak\EventSourcing\DBAL\Query\Page\Page;
use BartoszBartniczak\EventSourcing\DBAL\Query\Parameter\Parameter;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Query\QueryValidator;
use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::create
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::__construct
     */
    public function testCreate()
    {

        $queryBuilder = QueryBuilder::create();

        $this->assertEquals(new QueryBuilder(new Factory(), QueryValidator::create()), $queryBuilder);
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::__construct
     */
    public function testConstructorSetsDefaultsValues()
    {
        $this->markTestIncomplete();
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::from
     */
    public function testFrom()
    {
        $queryBuilder = QueryBuilder::create();

        $query = $queryBuilder->from('tableName')
            ->build();
        $this->assertSame('tableName', $query->getFrom());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::find
     */
    public function testFind()
    {
        $queryBuilder = QueryBuilder::create();

        $query = $queryBuilder
            ->from('test')
            ->find(1234)
            ->build();
        $this->assertEquals(new Quantity(1234), $query->getLimit());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::findAll
     */
    public function testFindAll()
    {
        $queryBuilder = QueryBuilder::create();

        $query = $queryBuilder
            ->from('test')
            ->findAll()
            ->build();
        $this->assertEquals(new FindAll(), $query->getLimit());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::page
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::setPage
     */
    public function testPage()
    {

        $queryBuilder = QueryBuilder::create();

        $query = $queryBuilder->from('test')
            ->page(2)
            ->build();

        $this->assertEquals(new Page(2), $query->getPage());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::where
     */
    public function testWhere()
    {

        $queryBuilder = QueryBuilder::create();

        $query = $queryBuilder->from('test')
            ->where('abc=123')
            ->build();

        $this->assertEquals(new ConditionsArray([new Condition('abc=123', new ArrayObject())]), $query->getConditions());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::setParameter
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\QueryBuilder::where
     */
    public function testSetParameterWithUnnamedParameters()
    {

        $queryBuilder = QueryBuilder::create();

        $query = $queryBuilder->from('test')
            ->where('id = ? and email = ?')
            ->setParameter(0, 123, Parameter::TYPE_INTEGER)
            ->setParameter(1, 'email@secret.com', Parameter::TYPE_STRING)
            ->build();

        $this->markTestIncomplete();

    }

}
