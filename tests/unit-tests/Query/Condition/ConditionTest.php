<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Bartniczak <kontakt@bartoszbartniczak.pl>
 */

namespace BartoszBartniczak\EventSourcing\DBAL\Query\Condition;

use BartoszBartniczak\ArrayObject\ArrayObject;
use PHPUnit\Framework\TestCase;

class ConditionTest extends TestCase
{

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition::__construct
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition::getCondition
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition::getValue
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition::setValue
     */
    public function testIntegerKeys()
    {
        $condition = new Condition('condition = ? and other = ?', new ArrayObject([0 => null, 1 => null]));
        $this->assertSame('condition = ? and other = ?', $condition->getCondition());
        $this->assertNull($condition->getValue(0));
        $condition->setValue(0, 100);
        $this->assertSame(100, $condition->getValue(0));
        $this->assertNull($condition->getValue(1));
    }

    /**
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition::__construct
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition::getCondition
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition::getValue
     * @covers \BartoszBartniczak\EventSourcing\DBAL\Query\Condition\Condition::setValue
     */
    public function testStringKeys()
    {
        $condition = new Condition('condition = :a and other b = :b', new ArrayObject(['a' => null, 'b' => null]));
        $this->assertSame('condition = :a and other b = :b', $condition->getCondition());
        $this->assertNull($condition->getValue('a'));
        $condition->setValue('a', 100);
        $this->assertSame(100, $condition->getValue('a'));
        $this->assertNull($condition->getValue('b'));
    }

}
