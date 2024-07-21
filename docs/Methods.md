# Detailed Method Descriptions

## `of(mixed $value): self`
- Returns an `Optional` with the specified non-null value.
- Throws `InvalidArgumentException` if the value is null.

## `ofNullable(mixed $value): self`
- Returns an `Optional` describing the specified value, if non-null, otherwise returns an empty `Optional`.

## `empty(): self`
- Returns an empty `Optional` instance.

## `isPresent(): bool`
- Returns `true` if there is a value present, otherwise `false`.

## `get(): mixed`
- Returns the value if present, otherwise throws `NoSuchElementException`.

## `orElse(mixed $other): mixed`
- Returns the value if present, otherwise returns the specified default value.

## `orElseGet(callable $supplier): mixed`
- Returns the value if present, otherwise invokes the supplier and returns the result.

## `orElseThrow(callable $exceptionSupplier): mixed`
- Returns the value if present, otherwise throws an exception created by the provided supplier.

## `ifPresent(callable $consumer): void`
- If a value is present, invokes the specified consumer with the value, otherwise does nothing.

## `map(callable $mapper): self`
- If a value is present, applies the provided mapping function to it and returns an `Optional` describing the result.

## `flatMap(callable $mapper): self`
- If a value is present, applies the provided `Optional`-bearing mapping function to it and returns that result, otherwise returns an empty `Optional`.

## `equals(Optional $other): bool`
- Indicates whether some other object is "equal to" this `Optional`.

## `hashCode(): string`
- Returns the hash code value of the present value, if any, or 0 if no value is present.
