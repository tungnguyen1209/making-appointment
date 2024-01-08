<?php

namespace App\Http\Events;

use App\Models\Appointment;
use Illuminate\Queue\SerializesModels;

class CreateAppointment
{
    use SerializesModels;

    /**
     * The appointment.
     *
     * @var Appointment
     */
    protected Appointment $appointment;

    /**
     * The type of appointment event.
     *
     * @var string
     */
    protected string $type;

    /**
     * Create a new event instance.
     *
     * @param Appointment $appointment
     * @param string $type
     */
    public function __construct(Appointment $appointment, string $type)
    {
        $this->appointment = $appointment;
        $this->type = $type;
    }

    /**
     * Get type of appointment event
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
