<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Validator\Condition;

use BartoszBartniczak\EventSourcing\DBAL\Condition\Condition;
use BartoszBartniczak\EventSourcing\DBAL\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Validator as ValidatorInterface;

class Validator implements ValidatorInterface
{

    /**
     * @param $data
     * @return bool
     * @throws InvalidArgumentException
     */
    public function validate($data): bool
    {

        if (!is_object($data)) {
            throw new InvalidArgumentException(sprintf(
                "Expected object type of '%s', '%s' given.",
                Condition::class,
                gettype($data)
            ));
        }

        if (!$data instanceof Condition) {
            throw new InvalidArgumentException(sprintf(
                "Expected object type of '%s', '%s' given.",
                Condition::class,
                get_class($data)
            ));
        }

        if (empty($data->getCondition())) {
            throw new InvalidArgumentException('Condition cannot be empty.');
        }

        if ($data->getValues()->count() === 0) {
            return true;
        } else {

            foreach ($data->getValues() as $key => $value) {
                if (empty($value)) {
                    throw new InvalidArgumentException(sprintf(
                        "Empty value. Value named '%s' is not set.",
                        $key
                    ));
                }
            }

            return true;

        }


    }

}