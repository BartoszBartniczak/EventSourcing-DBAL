<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Validator\Limit;

use BartoszBartniczak\EventSourcing\DBAL\Limit\FindAll;
use BartoszBartniczak\EventSourcing\DBAL\Limit\Limit;
use BartoszBartniczak\EventSourcing\DBAL\Limit\Quantity;
use BartoszBartniczak\EventSourcing\DBAL\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Limit\Quantity as QuantityValidator;
use BartoszBartniczak\EventSourcing\DBAL\Validator\UnexpectedValueException;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Validator as ValidatorInterface;

class Validator implements ValidatorInterface
{
    /**
     * @var QuantityValidator
     */
    private $quantityValidator;

    /**
     * Validator constructor.
     * @param QuantityValidator $quantityValidator
     */
    public function __construct(QuantityValidator $quantityValidator)
    {
        $this->quantityValidator = $quantityValidator;
    }

    /**
     * @return Validator
     */
    public static function create(): self
    {
        return new self(new QuantityValidator());
    }

    /**
     * @param $data
     * @return bool
     * @throws InvalidArgumentException
     * @throws UnexpectedValueException
     */
    public function validate($data): bool
    {

        if (!is_object($data)) {
            throw new InvalidArgumentException(sprintf(
                "Expected object type of '%s', '%s' given",
                Limit::class,
                gettype($data)
            ));
        }

        if (!$data instanceof Limit) {
            throw new InvalidArgumentException(
                sprintf(
                    "Expected object type of '%s', '%s' given.",
                    Limit::class,
                    get_class($data)
                )
            );
        }

        if ($data instanceof Quantity) {
            return $this->quantityValidator->validate($data);
        } elseif ($data instanceof FindAll) {
            return true;
        } else {
            throw new UnexpectedValueException('Unknown type of object.');
        }


    }


}