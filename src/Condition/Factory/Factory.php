<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Condition\Factory;


use BartoszBartniczak\ArrayObject\ArrayObject;
use BartoszBartniczak\EventSourcing\DBAL\Condition\Condition;

class Factory
{

    public function fromString(string $condition): Condition
    {

        list($condition, $values) = $this->parseCondition($condition);

        $condition = new Condition($condition, $values);
        return $condition;
    }

    private function parseCondition($condition): array
    {

        $unnamedParametersCounter = $this->countUnnamedParameters($condition);
        $namedParameters = $this->findNamedParameters($condition);
        $namedParametersCounter = sizeof($namedParameters);
        if ($unnamedParametersCounter > 0 && $namedParametersCounter > 0) {
            throw new InvalidArgumentException('Condition contains both: unnamed and named parameters. Cannot parse this condition.');
        } elseif ($unnamedParametersCounter > 0) {
            return [$condition, new ArrayObject(array_fill(0, $unnamedParametersCounter, null))];
        } elseif ($namedParametersCounter > 0) {
            $parameters = array_combine($namedParameters, array_fill(0, sizeof($namedParameters), null));
            $parameters = new ArrayObject($parameters);
            return [$condition, $parameters];
        } else {
            return [$condition, new ArrayObject()];
        }
    }

    /**
     * @param string $condition
     * @return int
     */
    private function countUnnamedParameters(string $condition): int
    {
        $regex = '/\?(\s|$)/';

        $matches = [];
        preg_match_all($regex, $condition, $matches);
        $matches = $matches[0];
        return sizeof($matches);
    }

    private function findNamedParameters(string $condition): array
    {
        $regex = '/\:[a-zA-Z_-]+(\s|$)/';

        $matches = [];
        preg_match_all($regex, $condition, $matches);
        $matches = $matches[0];

        $parameters = [];
        foreach ($matches as $parameter) {
            $parameter = substr($parameter, 1);
            $parameter = rtrim($parameter);
            $parameters[] = $parameter;
        }

        return $parameters;
    }

}