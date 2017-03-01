<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Validator\Condition;

use BartoszBartniczak\EventSourcing\DBAL\Condition\ConditionsArray;
use BartoszBartniczak\EventSourcing\DBAL\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Validator as ValidatorInterface;

class ArrayValidator implements ValidatorInterface
{

    /**
     * @var Validator
     */
    private $conditionValidator;

    /**
     * ArrayValidator constructor.
     * @param Validator $conditionValidator
     */
    public function __construct(Validator $conditionValidator)
    {
        $this->conditionValidator = $conditionValidator;
    }

    public static function create(): self
    {
        return new self(new Validator());
    }

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
                ConditionsArray::class,
                gettype($data)
            ));
        }

        if (!$data instanceof ConditionsArray) {
            throw new InvalidArgumentException(sprintf(
                "Expected object type of '%s', '%s' given.",
                ConditionsArray::class,
                get_class($data)
            ));
        }

        if ($data->count() === 0) {
            return true;
        } else {
            foreach ($data as $key => $value) {
                /* @var $value \BartoszBartniczak\EventSourcing\DBAL\Condition\Condition */
                $this->conditionValidator->validate($value);
            }
            return true;
        }

    }


}