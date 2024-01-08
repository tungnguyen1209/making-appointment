<?php

namespace App\Http\Listeners;

use App\Http\Events\CreateAppointment;

class SendEmailAppointmentNotification
{
    /**
     * Handle the event.
     *
     * @param CreateAppointment $event
     * @return void
     */
    public function handle(CreateAppointment $event): void
    {
        $type = $event->getType();
        $event->appointment->sendCreatedNotification($type);
    }
}
