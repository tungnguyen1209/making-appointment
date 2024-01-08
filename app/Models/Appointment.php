<?php

namespace App\Models;

use App\Notifications\CreateAppointment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'doctor_id',
        'appointment_datetime',
        'description',
        'status'
    ];

    /**
     * Send email when the appointment is created successfully
     *
     * @param string $type
     * @return void
     */
    public function sendCreatedNotification(string $type): void
    {
        $this->notify(new CreateAppointment($type));
    }
}
