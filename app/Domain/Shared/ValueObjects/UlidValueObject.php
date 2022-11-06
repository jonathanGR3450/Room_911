<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Symfony\Component\Uid\Ulid;

class UlidValueObject implements Stringable, UlidInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->guard($value);
        $this->value = $value;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public function guard(string $value)
    {
        if (Ulid::isValid($value)) {
            throw new InvalidArgumentException(sprintf('Value <%s> is not a valid ULID', $value));
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function fromPrimitives(string $value): static
    {
        return new static($value);
    }

    public static function random(): static
    {
        return new static((new Ulid())->__toString());
    }

    public function equals(UlidInterface $ulidInterface): bool
    {
        return $this->value() === $ulidInterface->value();
    }
}
