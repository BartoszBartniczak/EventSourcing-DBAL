<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL;


use BartoszBartniczak\EventSourcing\DBAL\Condition\ConditionsArray;
use BartoszBartniczak\EventSourcing\DBAL\Limit\Limit;
use BartoszBartniczak\EventSourcing\DBAL\Page\Page;

class Query
{

    /**
     * @var string
     */
    private $from;

    /**
     * It describes how many events you want to find
     * @var Limit
     */
    private $limit;

    /**
     * Page number of the results
     * @var Page
     */
    private $page;

    /**
     * @var ConditionsArray
     */
    private $requirements;

    /**
     * Query constructor.
     * @param string $from
     * @param Limit $limit
     * @param Page $page
     * @param ConditionsArray $requirements
     */
    public function __construct(string $from, Limit $limit, Page $page, ConditionsArray $requirements)
    {
        $this->from = $from;
        $this->limit = $limit;
        $this->page = $page;
        $this->requirements = $requirements;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return Limit
     */
    public function getLimit(): Limit
    {
        return $this->limit;
    }

    /**
     * @return Page
     */
    public function getPage(): Page
    {
        return $this->page;
    }

    /**
     * @return ConditionsArray
     */
    public function getConditions(): ConditionsArray
    {
        return $this->requirements;
    }


}