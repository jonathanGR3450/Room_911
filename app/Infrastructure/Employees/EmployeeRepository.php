<?php

declare(strict_types=1);

namespace App\Infrastructure\Employees;

use App\Domain\Employees\Aggregate\Employee;
use App\Domain\Employees\EmployeeRepositoryInterface;
use App\Domain\Employees\EmployeeSearchCriteria;
use App\Domain\Employees\Exception\EmployeeNotFoundException;
use App\Domain\Employees\ValueObjects\Department;
use App\Domain\Employees\ValueObjects\FirstName;
use App\Domain\Employees\ValueObjects\HasAccess;
use App\Domain\Employees\ValueObjects\Id;
use App\Domain\Employees\ValueObjects\LastName;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Infrastructure\Laravel\Models\Employee as ModelsEmployee;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function create(Employee $employee): void
    {
        $employeeModel = new ModelsEmployee();

        $employeeModel->id = $employee->id()->value();
        $employeeModel->first_name = $employee->firstName()->value();
        $employeeModel->last_name = $employee->lastName()->value();
        $employeeModel->department = $employee->department()->value();
        $employeeModel->has_access = $employee->hasAccess()->value();
        $employeeModel->created_at = DateTimeValueObject::now()->value();

        $employeeModel->save();
    }

    public function createManyEmployees(array $employees): void
    {
        ModelsEmployee::insert($employees);
    }

    public function update(Employee $employee): void
    {
        $employeeModel = ModelsEmployee::find($employee->id()->value());

        $employeeModel->id = $employee->id()->value();
        $employeeModel->first_name = $employee->firstName()->value();
        $employeeModel->last_name = $employee->lastName()->value();
        $employeeModel->department = $employee->department()->value();
        $employeeModel->has_access = $employee->hasAccess()->value();
        $employeeModel->updated_at = DateTimeValueObject::now()->value();

        $employeeModel->save();
    }

    public function findById(Id $id): Employee
    {
        $employeeModel = ModelsEmployee::find($id->value());

        if (empty($employeeModel)) {
            throw new EmployeeNotFoundException('Employee does not exist');
        }

        return self::map($employeeModel);
    }

    public function findByIdGetModel(Id $id): ModelsEmployee
    {
        $employeeModel = ModelsEmployee::find($id->value());

        if (empty($employeeModel)) {
            throw new EmployeeNotFoundException('Employee does not exist');
        }

        return $employeeModel;
    }

    public function searchById(Id $id): ?Employee
    {
        $employeeModel = ModelsEmployee::find($id->value());

        return $employeeModel != null ? self::map($employeeModel) : null;
    }

    public function searchByCriteria(EmployeeSearchCriteria $criteria): array
    {
        $employeeModel = new ModelsEmployee();

        if (!empty($criteria->firstName())) {
            $employeeModel = $employeeModel->where('first_name', 'ILIKE', "%" . $criteria->firstName() . "%");
        }

        if (!empty($criteria->lastName())) {
            $employeeModel = $employeeModel->where('last_name', 'ILIKE', "%" . $criteria->lastName() . "%");
        }

        if ($criteria->pagination() !== null) {
            $employeeModel = $employeeModel->take($criteria->pagination()->limit()->value())
                                    ->skip($criteria->pagination()->offset()->value());
        }

        if ($criteria->sort() !== null) {
            $employeeModel = $employeeModel->orderBy($criteria->sort()->field()->value(), $criteria->sort()->direction()->value());
        }

        return array_map(
            static fn (ModelsEmployee $employee) => self::map($employee),
            $employeeModel->get()->all()
        );
    }

    public function delete(Employee $employee): void
    {
        $employeeModel = ModelsEmployee::find($employee->id()->value());

        $employeeModel->delete();
    }

    public static function map(ModelsEmployee $model): Employee
    {
        return Employee::create(
            Id::fromPrimitives($model->id),
            FirstName::fromString($model->first_name),
            LastName::fromString($model->last_name),
            Department::fromString($model->department),
            HasAccess::fromBoolean((bool)$model->has_access),
            DateTimeValueObject::fromPrimitives($model->created_at->__toString()),
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives($model->updated_at->__toString()) : null,
        );
    }
}
