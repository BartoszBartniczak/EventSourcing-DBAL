<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Parameter;

class Factory
{

    public function create(string $type, $value): Parameter
    {

        if ($type === Parameter::TYPE_INT) {
            return $this->createInteger($value);
        } elseif ($type === Parameter::TYPE_STRING) {
            return $this->createString($value);
        } else {
            throw new \InvalidArgumentException();
        }
    }

    public function createInteger($value): IntegerParameter
    {
        return new IntegerParameter((int)$value);
    }

    public function createString($value): StringParameter
    {
        return new StringParameter((string)$value);
    }

}