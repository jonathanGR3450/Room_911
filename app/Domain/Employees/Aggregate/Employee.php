<?php

declare(strict_types=1);

namespace App\Domain\Employees\Aggregate;

use App\Domain\Employees\Contracts\EmployeeInterface;
use App\Domain\Employees\ValueObjects\Department;
use App\Domain\Employees\ValueObjects\FirstName;
use App\Domain\Employees\ValueObjects\HasAccess;
use App\Domain\Employees\ValueObjects\Id;
use App\Domain\Employees\ValueObjects\LastName;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;

final class Employee implements EmployeeInterface
{
    private function __construct(
        private Id $id,
        private FirstName $first_name,
        private LastName $last_name,
        private Department $department,
        private HasAccess $has_access,
        private DateTimeValueObject $created_at,
        private ?DateTimeValueObject $updated_at
    ) {
    }

    public static function create(
        Id $id,
        FirstName $first_name,
        LastName $last_name,
        Department $department,
        HasAccess $has_access,
        DateTimeValueObject $created_at,
        ?DateTimeValueObject $updated_at = null
    ): self {
        return new self(
            $id,
            $first_name,
            $last_name,
            $department,
            $has_access,
            $created_at,
            $updated_at
        );
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function firstName(): FirstName
    {
        return $this->first_name;
    }

    public function lastName(): LastName
    {
        return $this->last_name;
    }

    public function department(): Department
    {
        return $this->department;
    }

    public function hasAccess(): HasAccess
    {
        return $this->has_access;
    }

    public function updateDepartment(string $department): void
    {
        $this->department = Department::fromString($department);
    }

    public function updateHasAccess(bool $has_access): void
    {
        $this->has_access = HasAccess::fromBoolean($has_access);
    }

    public function createdAt(): DateTimeValueObject
    {
        return $this->created_at;
    }

    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updated_at;
    }

    public function updateFirstName(string $first_name): void
    {
        $this->name = FirstName::fromString($first_name);
    }

    public function updateLastName(string $first_name): void
    {
        $this->name = LastName::fromString($first_name);
    }

    public function employeeLoginAttempt(): void
    {
        // register attempt login employee
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'first_name' => $this->firstName()->value(),
            'last_name' => $this->lastName()->value(),
            'department' => $this->department()->value(),
            'has_access' => $this->hasAccess()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value()
        ];
    }
}
