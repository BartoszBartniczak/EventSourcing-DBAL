<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Validator\From;

use BartoszBartniczak\EventSourcing\DBAL\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Validator as ValidatorInterface;

class Validator implements ValidatorInterface
{
    public function validate($data): bool
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Table name cannot be empty.');
        }

        return true;
    }


}