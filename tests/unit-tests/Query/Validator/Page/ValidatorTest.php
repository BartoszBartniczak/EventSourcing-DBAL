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
use PHPUnit\Framework\TestCase;


class ValidatorTest extends TestCase
{

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Page\Validator::validate
     */
    public function testValidate()
    {

        $validator = new Validator();
        $this->assertInstanceOf(ValidatorInterface::class, $validator);

        $this->assertTrue($validator->validate(new Page(1)));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Page\Validator::validate
     */
    public function testValidateThrowsExceptionIfDataIsNotAnObject()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected object type of '" . Page::class . "', 'integer' given.");

        $validator = new Validator();
        $validator->validate(123);
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Page\Validator::validate
     */
    public function testValidateThrowsExceptionIfDataIsNotInstanceOfPage()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Expected object type of '" . Page::class . "', '" . \DateTime::class . "' given.");

        $validator = new Validator();
        $validator->validate(new \DateTime());
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Page\Validator::validate
     */
    public function testValidateThrowsExceptionIfPageIsLowerThanZero()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Page cannot be lower or equals to zero.');

        $validator = new Validator();
        $validator->validate(new Page(-1));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Validator\Page\Validator::validate
     */
    public function testValidateThrowsExceptionIfPageIsEqualsToZero()
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Page cannot be lower or equals to zero.');

        $validator = new Validator();
        $validator->validate(new Page(0));
    }

}
