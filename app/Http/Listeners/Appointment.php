<?php

namespace App\Http\Listeners;

use App\Http\Events\Appointment as AppointmentEvent;

class Appointment
{
    /**
     * Handle the event.
     *
     * @param AppointmentEvent $event
     * @return void
     */
    public function handle(AppointmentEvent $event): void
    {
        $type = $event->getType();
        $event->getAppointment()->sendNotification($type);
    }
}
