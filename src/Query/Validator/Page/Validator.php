<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Page;

use BartoszBartniczak\EventSourcing\DBAL\Query\Page\Page;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\UnexpectedValueException;
use BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Validator as ValidatorInterface;

class Validator implements ValidatorInterface
{
    public function validate($data): bool
    {

        if (!is_object($data)) {
            throw new InvalidArgumentException(sprintf(
                "Expected object type of '%s', '%s' given.",
                Page::class,
                gettype($data)
            ));
        }

        if (!$data instanceof Page) {
            throw new InvalidArgumentException(sprintf(
                "Expected object type of '%s', '%s' given.",
                Page::class,
                get_class($data)
            ));
        }

        if ($data->getValue() <= 0) {
            throw new UnexpectedValueException('Page cannot be lower or equals to zero.');
        }

        return true;

    }


}