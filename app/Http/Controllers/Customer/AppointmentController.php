<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ProfileUpdateRequest;
use App\Models\Appointment;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display the customer's appointments.
     */
    public function index(Request $request): View
    {
        $items = $request->user('customer')->getAppointments()->getResults();

        return view('customer.appointment.listing', [
            'items' => $items,
        ]);
    }

    /**
     * Create the customer's appointment.
     */
    public function create(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
                'phone' => ['required', 'digits_between:10,11'],
                'appointment_datetime' => ['required', 'string'],
                'description' => ['string']
            ]);

            $appointmentData = [
                'customer_id' => $request->user('customer')->id,
                'doctor_id' => null,
//                'email' => $request->email,
//                'phone' => $request->phone,
                'appointment_datetime' => $request->appointment_datetime,
                'status' => 'WAITING_FOR_CONFIRMATION',
                'description' => $request->description
            ];

            Appointment::query()->create($appointmentData);

            return redirect('/appointment');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the customer's appointment form.
     */
    public function edit(Request $request): View
    {
        return view('customer.appointment.edit', [
            'customer' => $request->user('customer'),
        ]);
    }

    /**
     * Update the customer's appointment information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user('customer')->fill($request->validated());

        if ($request->user('customer')->isDirty('email')) {
            $request->user('customer')->email_verified_at = null;
        }

        $request->user('customer')->save();

        return Redirect::route('customer.profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the customer's appointment.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $customer = $request->user('customer');

        Auth::guard('customer')->logout();

        $customer->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
