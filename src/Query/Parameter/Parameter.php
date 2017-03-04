<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Parameter;


abstract class Parameter
{
    const TYPE_STRING = 'string';
    const TYPE_INT = 'int';

    /**
     * @return mixed
     */
    abstract public function getValue();

}