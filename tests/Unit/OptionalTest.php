<?php

declare(strict_types=1);

namespace Phauthentic\Optional\Test\Unit;

use InvalidArgumentException;
use Phauthentic\Optional\NoSuchElementException;
use Phauthentic\Optional\Optional;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use stdClass;

/**
 *
 */
class OptionalTest extends TestCase
{
    public function testOfThrowsExceptionOnNull(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value cannot be null');
        Optional::of(null);
    }

    public function testOf(): void
    {
        $optional = Optional::of('value');
        $this->assertTrue($optional->isPresent());
        $this->assertEquals('value', $optional->get());
    }

    public function testOfNullableWithNull(): void
    {
        $optional = Optional::ofNullable(null);
        $this->assertFalse($optional->isPresent());
    }

    public function testOfNullableWithNonNull(): void
    {
        $optional = Optional::ofNullable('value');
        $this->assertTrue($optional->isPresent());
        $this->assertEquals('value', $optional->get());
    }

    public function testEmpty(): void
    {
        $optional = Optional::empty();
        $this->assertFalse($optional->isPresent());
    }

    public function testGetThrowsExceptionOnEmpty(): void
    {
        $optional = Optional::empty();
        $this->expectException(NoSuchElementException::class);
        $optional->get();
    }

    public function testOrElse(): void
    {
        $optional = Optional::empty();
        $this->assertEquals('default', $optional->orElse('default'));

        $optional = Optional::of('value');
        $this->assertEquals('value', $optional->orElse('default'));
    }

    public function testOrElseGet(): void
    {
        $optional = Optional::empty();
        $this->assertEquals('default', $optional->orElseGet(fn() => 'default'));

        $optional = Optional::of('value');
        $this->assertEquals('value', $optional->orElseGet(fn() => 'default'));
    }

    public function testOrElseThrowException(): void
    {
        $optional = Optional::empty();
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Test');
        $optional->orElseThrow(fn() => new RuntimeException('Test'));
    }

    public function testOrElseThrowWithValue(): void
    {
        $optional = Optional::of('value');
        $this->assertEquals('value', $optional->orElseThrow(fn() => new RuntimeException()));
    }

    public function testIfPresentWithValue(): void
    {
        $called = false;
        $optional = Optional::of('value');
        $optional->ifPresent(function ($value) use (&$called) {
            $this->assertEquals('value', $value);
            $called = true;
        });
        $this->assertTrue($called);
    }

    public function testIfPresentWithEmpty(): void
    {
        $called = false;
        $optional = Optional::empty();
        $optional->ifPresent(function ($value) use (&$called) {
            $called = true;
        });
        $this->assertFalse($called);
    }

    public function testMapWithValue(): void
    {
        $optional = Optional::of('value');
        $mapped = $optional->map(fn($value) => strtoupper($value));
        $this->assertTrue($mapped->isPresent());
        $this->assertEquals('VALUE', $mapped->get());
    }

    public function testMapWithEmpty(): void
    {
        $optional = Optional::empty();
        $mapped = $optional->map(fn($value) => strtoupper($value));
        $this->assertFalse($mapped->isPresent());
    }

    public function testFlatMapWithValue(): void
    {
        $optional = Optional::of('value');
        $flatMapped = $optional->flatMap(fn($value) => Optional::of(strtoupper($value)));
        $this->assertTrue($flatMapped->isPresent());
        $this->assertEquals('VALUE', $flatMapped->get());
    }

    public function testFlatMapWithEmpty(): void
    {
        $optional = Optional::empty();
        $flatMapped = $optional->flatMap(fn($value) => Optional::of(strtoupper($value)));
        $this->assertFalse($flatMapped->isPresent());
    }

    public function testFlatMapWithInvalidReturn(): void
    {
        $optional = Optional::of('value');
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The mapper function must return an instance of Phauthentic\Optional\Optional');
        $optional->flatMap(fn($value) => 'not an Optional');
    }

    public function testHashCodeWithStringValue(): void
    {
        $optional = Optional::of('test');
        $expectedHash = md5(serialize('test'));

        $this->assertSame($expectedHash, $optional->hashCode());
    }

    public function testHashCodeWithObjectValue(): void
    {
        $object = new stdClass();
        $optional = Optional::of($object);
        $expectedHash = spl_object_hash($object);

        $this->assertSame($expectedHash, $optional->hashCode());
    }

    public function testHashCodeWithEmptyOptional(): void
    {
        $optional = Optional::empty();
        $expectedHash = md5(serialize(null));

        $this->assertSame($expectedHash, $optional->hashCode());
    }

    public function testHashCodeWithArrayValue(): void
    {
        $array = ['a', 'b', 'c'];
        $optional = Optional::of($array);
        $expectedHash = md5(serialize($array));

        $this->assertSame($expectedHash, $optional->hashCode());
    }

    public function testEqualsWithBothValuesPresentAndEqual(): void
    {
        $optional1 = Optional::of('value');
        $optional2 = Optional::of('value');
        $this->assertTrue($optional1->equals($optional2));
    }

    public function testEqualsWithBothValuesPresentAndNotEqual(): void
    {
        $optional1 = Optional::of('value1');
        $optional2 = Optional::of('value2');
        $this->assertFalse($optional1->equals($optional2));
    }

    public function testEqualsWithOneValuePresentAndOtherEmpty(): void
    {
        $optional1 = Optional::of('value');
        $optional2 = Optional::empty();
        $this->assertFalse($optional1->equals($optional2));
    }

    public function testEqualsWithBothValuesEmpty(): void
    {
        $optional1 = Optional::empty();
        $optional2 = Optional::empty();
        $this->assertTrue($optional1->equals($optional2));
    }

    public function testEqualsWithDifferentTypes(): void
    {
        $optional1 = Optional::of('value');
        $optional2 = Optional::of(123);
        $this->assertFalse($optional1->equals($optional2));
    }

    public function testEqualsWithBothValuesAsObjectsEqual(): void
    {
        $object1 = new stdClass();
        $object1->property = 'value';
        $object2 = new stdClass();
        $object2->property = 'value';

        $optional1 = Optional::of($object1);
        $optional2 = Optional::of($object2);

        $this->assertFalse($optional1->equals($optional2));
    }

    public function testEqualsWithBothValuesAsObjectsIdentical(): void
    {
        $object = new stdClass();
        $object->property = 'value';

        $optional1 = Optional::of($object);
        $optional2 = Optional::of($object);

        $this->assertTrue($optional1->equals($optional2));
    }

    public function testEqualsWithDifferentOptionalTypes(): void
    {
        $optional1 = Optional::of('value');
        $optional2 = Optional::ofNullable(null);
        $this->assertFalse($optional1->equals($optional2));
    }
}
