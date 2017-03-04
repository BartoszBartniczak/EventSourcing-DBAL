<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Condition;

use BartoszBartniczak\ArrayObject\ArrayObject;

class Condition
{

    /**
     * @var string
     */
    private $condition;

    /**
     * @var ArrayObject
     */
    private $values;

    /**
     * Condition constructor.
     * @param string $condition
     * @param ArrayObject $values
     */
    public function __construct(string $condition, ArrayObject $values)
    {
        $this->condition = $condition;
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @return ArrayObject
     */
    public function getValues(): ArrayObject
    {
        return $this->values;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function setValue($key, $value)
    {
        $this->values[$key] = $value;
    }

    /**
     * @return mixed
     */
    public function getValue($key)
    {
        return $this->values[$key];
    }

}