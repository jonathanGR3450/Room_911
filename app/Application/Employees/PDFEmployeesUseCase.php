<?php

declare(strict_types=1);

namespace App\Application\Employees;

use App\Domain\Employees\Aggregate\Employee;
use App\Domain\Employees\EmployeeRepositoryInterface;
use PDF;

final class PDFEmployeesUseCase
{
    private EmployeeRepositoryInterface $employeeRepositoryInterface;

    public function __construct(EmployeeRepositoryInterface $employeeRepositoryInterface) {
        $this->employeeRepositoryInterface = $employeeRepositoryInterface;
    }

    public function __invoke(): \Barryvdh\DomPDF\PDF
    {
        $employees = $this->employeeRepositoryInterface->getAllEmployees();
        $pdf = Employee::pdfEmployees($employees);
        return $pdf;
    }
}