<?php

declare(strict_types=1);

namespace Phauthentic\Optional;

use InvalidArgumentException;

/**
 * A container object which may or may not contain a non-null value. If a value is present, isPresent() will return
 * true and get() will return the value. Additional methods that depend on the presence or absence of a contained value
 * are provided, such as orElse() (return a default value if value not present) and ifPresent() (execute a block of
 * code if the value is present).
 *
 * This is a value-based class; use of identity-sensitive operations (including reference equality (===), identity hash
 * code, or synchronization) on instances of Optional may have unpredictable results and should be avoided.
 *
 * @link https://docs.oracle.com/javase/8/docs/api/java/util/Optional.html
 */
class Optional
{
    protected mixed $value;

    /**
     * @param mixed $value
     */
    protected function __construct(mixed $value = null)
    {
        $this->value = $value;
    }

    /**
     * Returns an Optional with the specified present non-null value.
     *
     * @param mixed $value
     * @return self
     */
    public static function of(mixed $value): self
    {
        if ($value === null) {
            throw new InvalidArgumentException('Value cannot be null');
        }

        return new self($value);
    }

    /**
     * Returns an Optional describing the specified value, if non-null, otherwise returns an empty Optional.
     *
     * @param mixed $value
     * @return self
     */
    public static function ofNullable(mixed $value): self
    {
        return new self($value);
    }

    /**
     * Returns an empty Optional instance.
     */
    public static function empty(): self
    {
        return new self();
    }

    /**
     * Return true if there is a value present, otherwise false.
     */
    public function isPresent(): bool
    {
        return $this->value !== null;
    }

    /**
     * If a value is present in this Optional, returns the value, otherwise throws NoSuchElementException.
     */
    public function get(): mixed
    {
        if ($this->value === null) {
            throw new NoSuchElementException('No value present');
        }

        return $this->value;
    }

    public function orElse(mixed $other): mixed
    {
        return $this->value ?? $other;
    }

    /**
     * Return the value if present, otherwise invoke other and return the result of that invocation.
     *
     * @param callable $supplier
     * @return mixed
     */
    public function orElseGet(callable $supplier): mixed
    {
        return $this->value ?? $supplier();
    }

    /**
     * Return the contained value, if present, otherwise throw an exception to be created by the provided supplier.
     *
     * @param callable $exceptionSupplier
     * @return mixed
     */
    public function orElseThrow(callable $exceptionSupplier): mixed
    {
        if ($this->value !== null) {
            return $this->value;
        }

        throw $exceptionSupplier();
    }

    /**
     * If a value is present, invoke the specified consumer with the value, otherwise do nothing.
     */
    public function ifPresent(callable $consumer): void
    {
        if ($this->value !== null) {
            $consumer($this->value);
        }
    }

    /**
     * If a value is present, apply the provided mapping function to it, and if the result is non-null, return an
     * Optional describing the result. Otherwise, return an empty Optional.
     */
    public function map(callable $mapper): self
    {
        if ($this->value === null) {
            return self::empty();
        }

        return self::ofNullable($mapper($this->value));
    }

    /**
     * If a value is present, apply the provided Optional-bearing mapping function to it, return that result, otherwise
     * return an empty Optional.
     */
    public function flatMap(callable $mapper): self
    {
        if ($this->value === null) {
            return self::empty();
        }

        $result = $mapper($this->value);
        if (!$result instanceof self) {
            throw new InvalidArgumentException('The mapper function must return an instance of ' . self::class);
        }

        return $result;
    }

    /**
     * Indicates whether some other object is "equal to" this Optional.
     *
     * The other object is considered equal if:
     * - it is also an Optional and;
     * - both instances have no value present or;
     * - the present values are "equal to" each other via equals().
 */
    public function equals(Optional $other): bool
    {
        return (!$this->isPresent() && !$other->isPresent())
            || ($this->IsPresent() && $other->isPresent() && $this->get() === $other->get());
    }

    /**
     * Returns the hash code value of the present value, if any, or 0 (zero) if no value is present.
     */
    public function hashCode(): string
    {
        if (is_object($this->value)) {
            return spl_object_hash($this->value);
        }

        return md5(serialize($this->value));
    }
}
