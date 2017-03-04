<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Query;


use BartoszBartniczak\EventSourcing\DBAL\Query\Condition\ConditionsArray;
use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\Limit;
use BartoszBartniczak\EventSourcing\DBAL\Query\Page\Page;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Condition\ArrayValidator as ConditionsValidator;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\From\Validator as FromValidator;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit\Validator as LimitValidator;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Page\Validator as PageValidator;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\ValidatorException;

class QueryValidator
{
    /**
     * @var FromValidator
     */
    private $fromValidator;

    /**
     * @var LimitValidator
     */
    private $limitValidator;

    /**
     * @var PageValidator
     */
    private $pageValidator;

    /**
     * @var ConditionsValidator
     */
    private $conditionsValidator;

    /**
     * QueryValidator constructor.
     * @param FromValidator $fromValidator
     * @param LimitValidator $limitValidator
     * @param PageValidator $pageValidator
     * @param ConditionsValidator $conditionsValidator
     */
    public function __construct(FromValidator $fromValidator, LimitValidator $limitValidator, PageValidator $pageValidator, ConditionsValidator $conditionsValidator)
    {
        $this->fromValidator = $fromValidator;
        $this->limitValidator = $limitValidator;
        $this->pageValidator = $pageValidator;
        $this->conditionsValidator = $conditionsValidator;
    }

    /**
     * @return QueryValidator
     */
    public static function create(): self
    {
        return new self(
            new FromValidator(),
            LimitValidator::create(),
            new PageValidator(),
            ConditionsValidator::create()
        );
    }

    /**
     * @param string $from
     * @param Limit $limit
     * @param Page $page
     * @param ConditionsArray $conditions
     * @throws ValidatorException
     */
    public function validateConstructorArgs(string $from, Limit $limit, Page $page, ConditionsArray $conditions)
    {
        $this->validateFrom($from);
        $this->validateLimit($limit);
        $this->validatePage($page);
        $this->validateConditions($conditions);
    }

    /**
     * @param string $from
     * @throws ValidatorException
     */
    private function validateFrom(string $from)
    {
        $this->fromValidator->validate($from);
    }

    /**
     * @param Limit $limit
     * @throws ValidatorException
     */
    private function validateLimit(Limit $limit)
    {
        $this->limitValidator->validate($limit);
    }

    /**
     * @param Page $page
     * @throws ValidatorException
     */
    private function validatePage(Page $page)
    {
        $this->pageValidator->validate($page);
    }

    /**
     * @param ConditionsArray $conditions
     * @throws ValidatorException
     */
    private function validateConditions(ConditionsArray $conditions)
    {
        $this->conditionsValidator->validate($conditions);
    }


}