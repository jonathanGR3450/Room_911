<?php

namespace App\Domain\Employees\Events;

use App\Domain\Employees\Contracts\EmployeeInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmployeeSession
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public EmployeeInterface $employee;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(EmployeeInterface $employee)
    {
        $this->employee = $employee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
