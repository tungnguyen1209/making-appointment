<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class CreateAppointment extends Notification implements ShouldQueue
{
    public const CREATED_EVENT = 'created';
    public const CANCELED_EVENT = 'canceled';
    public const CONFIRMED_EVENT = 'confirmed';
    public const ASSIGNED_DOCTOR_EVENT = 'assigned_doctor';
    public const COMPLETED_EVENT = 'completed';

    use Queueable;

    /**
     * @var string
     */
    protected string $type;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return MailMessage
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('Verify Email Address'))
            ->line(Lang::get('Please click the button below to verify your email address.'))
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            //
        ];
    }
}
