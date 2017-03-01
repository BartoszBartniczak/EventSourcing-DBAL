<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Condition;


use BartoszBartniczak\ArrayObject\ArrayOfObjects;

class ConditionsArray extends ArrayOfObjects
{

    public function __construct(array $input = null, int $flags = 0, $iterator_class = "ArrayIterator")
    {
        parent::__construct(Condition::class, $input, $flags, $iterator_class);
    }

}