<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Validator;


interface Validator
{

    /**
     * Throws exception if at least one requirement is not fulfilled
     * @param $data
     * @return bool
     */
    public function validate($data): bool;

}