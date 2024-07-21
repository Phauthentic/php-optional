# PHP Version of Javas Optional

PHP version of [Javas Optional class](https://docs.oracle.com/javase/8/docs/api/java/util/Optional.html) is used to represent a container object which may or may not contain a non-null  value.

> A container object which may or may not contain a non-null value. If a value is present, isPresent() will return true and get() will return the value. Additional methods that depend on the presence or absence of a contained value  are provided, such as orElse() (return a default value if value not present) and ifPresent() (execute a block of code if the value is present).
> 
> This is a value-based class; use of identity-sensitive operations (including reference equality (==), identity hash code, or synchronization) on instances of Optional may have unpredictable results and should be avoided.

One downside of using PHP is the lack of [generics](https://en.wikipedia.org/wiki/Generics_in_Java). Therefor you'll have to annotate your code with the type of the value you expect to be in the Optional.

## Installation

```bash
composer require phauthentic/php-optional
```

## When to Use Optional and Why

The Optional class is a powerful tool designed to handle situations where a value may or may not be present. Here’s when and why you should use it:

* **Avoiding Null Checks:** When you have a method that might return a value or might return null, using Optional allows you to avoid explicit null checks. Instead of checking if ($value !== null), you can use Optional methods like isPresent() and get().
* **Functional Programming:** If you are using functional programming techniques, Optional fits well with methods like map(), flatMap(), and ifPresent(). These methods allow you to apply transformations and actions on the contained value only if it is present, leading to more readable and concise code.
* **API Design:** When designing APIs, returning an Optional makes it clear to the caller that the returned value may be absent, encouraging them to handle this possibility explicitly.

## Why Use Optional?

* **Clarity and Intent:** Using Optional makes the code more expressive. It clearly communicates that a value may be absent, making the code easier to understand and maintain.
* **Reducing Errors:** By using Optional, you minimize the risk of NullPointerExceptions (or similar null reference errors). The explicit handling of absence reduces the likelihood of runtime errors.
* **Encouraging Best Practices:** Optional encourages developers to think about the absence of a value and handle it appropriately, promoting better coding practices.

## Example Scenario

Imagine you have a method findUserById($id) that retrieves a user by their ID. Without Optional, you might write:

```php
$user = $repository->findUserById($id);
if ($user !== null) {
    // Process user
} else {
    // Handle absence
}
```

With Optional, the method can return an Optional object:

```php
$optionalUser = $repository->findUserById($id);
$optionalUser->ifPresent(function($user) {
    // Process user
});
```

Or handle the absence more fluently:

```php
$user = $optionalUser->orElse(new DefaultUser());
```

In this way, Optional helps you write cleaner, safer, and more expressive code.

## License

Copyright Florian Krämer

Licensed under the [MIT license](LICENSE).
