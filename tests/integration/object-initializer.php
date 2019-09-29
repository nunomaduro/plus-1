<?php

declare(strict_types=1);

declare(plus=1);

namespace Foo;

class ValueObject
{
    public $name;
}

test('can initialize objects without parentheses', () => {
    $valueObject = new ValueObject {
        name = 'Nuno' // checks if setName exists, otherwise uses the property.
    };

    assertInstanceOf(ValueObject::class, $valueObject);
    assertEquals('Nuno', $valueObject->name);
});

class ValueObjectWithDependencies
{
    public $name;

    public __construct($foo) {
        $this->foo = $foo;
    }
}

test('can initialize objects with parentheses', () => {
    $valueObject = new ValueObjectWithDependencies('foo') {
        name = 'Nuno'
    };
    assertInstanceOf(ValueObjectWithDependencies::class, $valueObject);
    assertEquals('Nuno', $valueObject->name);
    assertEquals('foo', $valueObject->foo);
});

/** @todo  Use reflection on macro to check if setter exists
 *
class ValueObjectWithSetter
{
    public $name;

    public setName(): void
    {
        $this->name = strtoupper($name);
    }
}

test('can initialize objects with parentheses', () => {
    $valueObject = new ValueObjectWithSetter {
        name = 'Nuno'
    };
    assertInstanceOf(ValueObjectWithSetter::class, $valueObject);
    assertEquals('NUNO', $valueObject->name);
});
 *
 */

