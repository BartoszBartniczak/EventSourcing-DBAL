<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Validator\From;


use BartoszBartniczak\EventSourcing\DBAL\Validator\InvalidArgumentException;
use BartoszBartniczak\EventSourcing\DBAL\Validator\Validator as ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\From\Validator::validate
     */
    public function testValidate()
    {
        $this->assertInstanceOf(ValidatorInterface::class, $this->validator);

        $this->assertTrue($this->validator->validate('table_name'));
        $this->assertTrue($this->validator->validate('tableName'));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Validator\From\Validator::validate
     */
    public function testValidateThrowsExceptionIfNameIsEmpty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Table name cannot be empty.');

        $this->validator->validate('');
    }

    protected function setUp()
    {
        $this->validator = new Validator();
    }
}
