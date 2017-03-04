<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Limit;


use BartoszBartniczak\EventSourcing\DBAL\Query\Limit\Quantity as QuantityLimit;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\UnexpectedValueException;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Validator;

class Quantity implements Validator
{
    /**
     * @inheritdoc
     */
    public function validate($data): bool
    {
        if (!is_object($data)) {
            throw new InvalidArgumentException(
                sprintf(
                    "Object expected of type '%s', '%s' given.",
                    QuantityLimit::class,
                    gettype($data)
                )
            );

        }

        if (!$data instanceof QuantityLimit) {

            throw new InvalidArgumentException(
                sprintf(
                    "Object expected of type '%s', '%s' given.",
                    QuantityLimit::class,
                    get_class($data)
                )
            );

        }

        /* @var $data QuantityLimit */
        if ($data->getValue() <= 0) {
            throw new UnexpectedValueException('Quantity cannot be lower or equals to zero.');
        }

        return true;
    }


}