<?php

namespace App\Http\Events;

use App\Models\Appointment as AppointmentModel;
use Illuminate\Queue\SerializesModels;

class Appointment
{
    use SerializesModels;

    /**
     * The appointment.
     *
     * @var AppointmentModel
     */
    protected AppointmentModel $appointment;

    /**
     * The type of appointment event.
     *
     * @var string
     */
    protected string $type;

    /**
     * Create a new event instance.
     *
     * @param AppointmentModel $appointment
     * @param string $type
     */
    public function __construct(AppointmentModel $appointment, string $type)
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

    /**
     * Get Appointment model
     *
     * @return AppointmentModel
     */
    public function getAppointment(): AppointmentModel
    {
        return $this->appointment;
    }
}
