# Usage Examples

## 1. Creating an Optional

```php
use Phauthentic\Optional\Optional;

// Creating an Optional with a non-null value
$optional = Optional::of('Hello');
echo $optional->get(); // Outputs: Hello

// Creating an Optional that may be null
$optionalNullable = Optional::ofNullable(null);
var_dump($optionalNullable->isPresent()); // Outputs: bool(false)

// Creating an empty Optional
$emptyOptional = Optional::empty();
var_dump($emptyOptional->isPresent()); // Outputs: bool(false)
```

## 2. Checking if a Value is Present

```php
$optional = Optional::of('Hello');
if ($optional->isPresent()) {
    echo $optional->get(); // Outputs: Hello
}
```

## 3. Getting the Value with a Default

```php
$optional = Optional::empty();
echo $optional->orElse('Default Value'); // Outputs: Default Value

$optionalWithValue = Optional::of('Hello');
echo $optionalWithValue->orElse('Default Value'); // Outputs: Hello
```

## 4. Using orElseGet with a Supplier

```php
$optional = Optional::empty();
echo $optional->orElseGet(fn() => 'Generated Value'); // Outputs: Generated Value
```

## 5. Throwing an Exception if No Value is Present

```php
$optional = Optional::empty();
try {
    $optional->orElseThrow(fn() => new \Exception('No value present'));
} catch (\Exception $e) {
    echo $e->getMessage(); // Outputs: No value present
}
```

# 6. Executing Code if a Value is Present

```php
$optional = Optional::of('Hello');
$optional->ifPresent(function($value) {
    echo $value; // Outputs: Hello
});
```

## 7. Transforming the Value with map

```php
$optional = Optional::of('Hello');
$mapped = $optional->map(fn($value) => strtoupper($value));
echo $mapped->get(); // Outputs: HELLO
```

## 8. Flattening Nested Optionals with flatMap

```php
$optional = Optional::of('Hello');
$flatMapped = $optional->flatMap(fn($value) => Optional::of(strtoupper($value)));
echo $flatMapped->get(); // Outputs: HELLO

$emptyOptional = Optional::empty();
$flatMappedEmpty = $emptyOptional->flatMap(fn($value) => Optional::of(strtoupper($value)));
var_dump($flatMappedEmpty->isPresent()); // Outputs: bool(false)
```

## 9. Comparing Optionals with equals

```php
$optional1 = Optional::of('Hello');
$optional2 = Optional::of('Hello');
$optional3 = Optional::empty();

var_dump($optional1->equals($optional2)); // Outputs: bool(true)
var_dump($optional1->equals($optional3)); // Outputs: bool(false)
var_dump($optional3->equals(Optional::empty())); // Outputs: bool(true)
```

## 10. Getting the Hash Code of the Value

```php
$optional = Optional::of('Hello');
echo $optional->hashCode(); // Outputs the hash code of the value "Hello"

$emptyOptional = Optional::empty();
echo $emptyOptional->hashCode(); // Outputs: 0
```
