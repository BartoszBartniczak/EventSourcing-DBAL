<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL;


use BartoszBartniczak\EventSourcing\DBAL\Condition\ConditionsArray;
use BartoszBartniczak\EventSourcing\DBAL\Condition\Factory\Factory as ConditionFactory;
use BartoszBartniczak\EventSourcing\DBAL\Limit\FindAll;
use BartoszBartniczak\EventSourcing\DBAL\Limit\Limit;
use BartoszBartniczak\EventSourcing\DBAL\Limit\Quantity;
use BartoszBartniczak\EventSourcing\DBAL\Page\Page;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Query\QueryValidator;

class QueryBuilder
{
    /**
     * @var QueryValidator
     */
    protected $queryValidator;

    /**
     * @var string
     */
    private $from;

    /**
     * @var Limit
     */
    private $limit;

    /**
     * @var Page
     */
    private $page;

    /**
     * @var ConditionsArray
     */
    private $conditions;

    /**
     * @var ConditionFactory
     */
    private $conditionFactory;

    /**
     * QueryBuilder constructor.
     * @param ConditionFactory $conditionFactory
     */
    public function __construct(ConditionFactory $conditionFactory, QueryValidator $queryValidator)
    {
        $this->queryValidator = $queryValidator;
        $this->conditionFactory = $conditionFactory;
        $this->conditions = new ConditionsArray();
        $this->page(1);
        $this->findAll();
        $this->from('');
    }

    /**
     * @param int $number
     * @return QueryBuilder
     */
    public function page(int $number): self
    {
        $this->setPage(new Page($number));
        return $this;
    }

    /**
     * @param Page $page
     * @return QueryBuilder
     */
    private function setPage(Page $page): self
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return QueryBuilder
     */
    public function findAll(): self
    {
        $this->setLimit(new FindAll());
        return $this;
    }

    /**
     * @param Limit $limit
     */
    private function setLimit(Limit $limit)
    {
        $this->limit = $limit;
    }

    /**
     * @param string $table
     * @return QueryBuilder
     */
    public function from(string $table): self
    {
        $this->from = $table;
        return $this;
    }

    /**
     * @return QueryBuilder
     */
    public static function create(): self
    {
        return new self(new ConditionFactory(), QueryValidator::create());
    }

    /**
     * @param int $quantity
     * @return QueryBuilder
     */
    public function find(int $quantity): self
    {
        $this->setLimit(new Quantity($quantity));
        return $this;
    }

    public function build(): Query
    {
        $this->queryValidator->validateConstructorArgs($this->from, $this->limit, $this->page, $this->conditions);

        return new Query($this->from, $this->limit, $this->page, $this->conditions);
    }

    public function where(string $condition): self
    {
        $this->conditions[] = $this->conditionFactory->fromString($condition);
        return $this;
    }

    public function setParameter(string $name, $value, string $type)
    {
        $this->conditions->setParameter($name, $value, $type);
        return $this;
    }

}