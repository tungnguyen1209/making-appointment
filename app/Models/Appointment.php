<?php

namespace App\Models;

use App\Notifications\Appointment as AppointmentNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    public const WAITING_FOR_CONFIRM = 'WAITING_FOR_CONFIRM';
    public const CONFIRMED = 'CONFIRMED';
    public const CANCELED = 'CANCELED';
    public const ASSIGNED_TO_DOCTOR = 'ASSIGNED_TO_DOCTOR';
    public const COMPLETED = 'COMPLETED';


    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'customer_id',
        'doctor_id',
        'address_id',
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
    public function sendNotification(string $type): void
    {
        $this->notify(new AppointmentNotification($type));
    }

    /**
     * Get All appointment images
     *
     * @return HasMany
     */
    public function getImages(): HasMany
    {
        return $this->hasMany(AppointmentImage::class);
    }
}
