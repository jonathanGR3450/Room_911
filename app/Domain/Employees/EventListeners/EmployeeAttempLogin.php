<?php

namespace App\Domain\User\EventListeners;

use App\Domain\Employees\Events\EmployeeSession;
use Illuminate\Support\Facades\Mail;

class EmployeeAttempLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Domain\Employees\Events\EmployeeSession $event
     * @return void
     */
    public function handle(EmployeeSession $event)
    {
        $event->employee->employeeLoginAttempt();
    }
}
