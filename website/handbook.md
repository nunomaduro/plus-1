# Handbook

> This document is a work in progress, it may still change, perhaps profoundly.

As discussed on the [prologue](prologue.html), in **Plus**, we add features to
PHP that you probably have already saw in other languages. Of course, we compile
those new features down to PHP that works across all platforms.

Let’s take a look at a simple class-based example:

```php
internal class User
{
    public readonly string $name;

    public __construct(string $name) {
        $this->name = $name;
    }

    public getName(): string => $this->name;
}
```

The syntax should look familiar if you have used PHP before - so now,
let's walk through what **Plus** has to offer:

## Optional `function` keyword

If you have done PHP before, you probably have used the syntax bellow
while declaring a class method:

```php
class User
{
    // ..

    public function getName(): string
    {
        return $this->name;
    }
}
```


With **Plus**, we belive the `function` keyword is relatively useless. So we allow you to do:

```php
class User
{
    // ..

   public getName(): string
    {
        return $this->name;
    }
}
```

## Arrow function methods

Even better, you can have one line arrow functions. Keep in mind that the `return` keyword is hidden
in those one-line arrow functions:

```php
class User
{
    // ..

    public getName(): string => $this->name;
}
```

So in the example above, we are going to return the name of the user. Note that, the
`string` return type is optional.

## Typed properties

A property class-specific variable belonging to the class. With **Plus**, each property has
may be associated with a type. In our example, the `$name` property is a `string`, so let's
add the type within the code:

```php
class User
{
    public string $name;

    // ..
}
```

## Non-constant properties assignment

With **Plus**, the default value of a property may or not be a constant value. And it
can depend from run-time information.

```php
class User
{
    public Name $name = new Name('Nuno');

    public callable $nameFormatter = (Name $name) => ucwords($name->toString());

    // ..
}
```

Keep in mind that, the `__constructor` must be called to those assignments to happen. Reflection
functions like `ReflectionClass::newInstanceWithoutConstructor()` will return a instance with
those properties containing `null` values.

## Readonly properties

**Plus** has built-in support for public properties that can be read anywhere, but only
written to once - on initialisation level. Those properties should contain the
`readonly` modifier:

```php
class User
{
    public readonly string $name;

    // ..
}
```

Readonly properties must be initialized at their declaration or in the constructor. This allows
you to work in a functional way, as unexpected mutation is forbidden.

## Internal classes

If you are open source maintainer, refactoring after a stable release of your open source library
can be hard, because technically in PHP **every class is public**. With **Plus**, the `internal`
keyword can be used to denote that the associated class is internal to the library:

```php
internal class User
{
    // ..
}
```

With the `internal` keyword, you can clearly define what classes that are not meant to be used
by others, and at the same time, you can confidently refactor the internals of your library
without breaking people’s code.

## Enumerations

Enums allow us to define a set of named constants. Using enums can make it easier to document
intent, or create a set of distinct cases. **Plus** provides both numeric and string-based enums.

An enum can be defined using the `enum` keyword:

```php
enum Direction {
    Up = 'up',
    Down = 'down'
}

enum Response {
    No = 0,
    Yes = 1
}

$user->answer(Response::Yes);
```

## Arrow functions

Arrow functions, also called short closures, are a way of writing shorter functions
in **Plus**. This notation is useful when passing callbacks to functions like `array_map`
or `array_filter`:

```php
$names = array_map(($user) => $user->name, $users);

$names = array_map(($user) => {
    return $user->name;
}, $users);
```

Keep in mind, arrow functions lexically captures the meaning of `$this`, and
the meaning of the entire scope:

```php
$nameGetter = () => $this->name;

// or
$name = $this->name;
$nameGetter = () => $name;
```

## Reserved names

Variables, properties, constants, and class names should never be prefixed with the word `__plus`. Using the prefix `__plus` can cause unexpected behaviour in your application.
