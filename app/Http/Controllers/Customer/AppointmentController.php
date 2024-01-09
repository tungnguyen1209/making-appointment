<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Events\Appointment as AppointmentEvent;
use App\Models\Appointment;
use App\Models\CustomerAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use App\Notifications\Appointment as CreateAppointmentNotification;

class AppointmentController extends Controller
{
    /**
     * Display the customer's appointments.
     */
    public function index(Request $request): View
    {
        $items = $request->user('customer')->getAppointments()->getResults();
        $itemsCount = $items->count();

        return view('customer.appointment.listing', [
            'items' => $items,
            'itemsCount' => $itemsCount
        ]);
    }

    /**
     * Create the customer's appointment form.
     */
    public function createForm(Request $request): View
    {
        $addresses = $request->user('customer')->getAddresses()->getResults();
        $items = [];
        foreach ($addresses as $address) {
            $items[] = ['id' => $address->id, 'name' => $address->details];
        }

        return view('customer.appointment.create', [
            'addresses' => $items
        ]);
    }

    /**
     * Create the customer's appointment.
     */
    public function create(Request $request): RedirectResponse
    {
        try {
            $this->validateRequest($request);

            $appointmentData = [
                'customer_id' => $request->user('customer')->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address_id' => $request->address_id,
                'appointment_datetime' => $request->appointment_datetime,
                'status' => Appointment::WAITING_FOR_CONFIRM,
                'description' => $request->description
            ];

            $appointment = Appointment::query()->create($appointmentData);
            event(new AppointmentEvent($appointment, CreateAppointmentNotification::CREATED_EVENT));

            return redirect('/appointment')->with('success', __('Appointment Created Successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the customer's appointment form.
     */
    public function view(Request $request): View
    {
        $appointment = Appointment::query()->findOrFail($request->id);
        $addresses = $request->user('customer')->getAddresses()->getResults();
        $addressItems = [];
        foreach ($addresses as $address) {
            $addressItems[] = ['id' => $address->id, 'name' => $address->details];
        }

        return view('customer.appointment.view', [
            'appointment' => $appointment,
            'addresses' => $addressItems,
        ]);
    }

    /**
     * Update the customer's appointment information.
     */
    public function update(Request $request): RedirectResponse
    {
        try {
        $this->validateRequest($request);
        $appointment = Appointment::query()->findOrFail($request->id);
        $appointment->fill($request->all());
        $appointment->save();

        return Redirect::route('customer.appointment.view', ['id' => $request->id])->with('success', __('Appointment Updated Successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Cancel the customer's appointment.
     */
    public function cancel(Request $request): RedirectResponse
    {
        try {
            $appointment = Appointment::query()->findOrFail($request->id);
            $appointment->fill(['status' => Appointment::CANCELED]);
            $appointment->save();
            event(new AppointmentEvent($appointment, CreateAppointmentNotification::CANCELED_EVENT));

            return Redirect::to('/appointment');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Validate Request
     *
     * @param Request $request
     * @return void
     */
    protected function validateRequest(Request $request): void
    {
        $request->validate([
            'address_id' => ['required', 'integer', Rule::exists(CustomerAddress::class, 'id')],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone' => ['required', 'digits_between:10,11'],
            'appointment_datetime' => ['required', 'string'],
            'description' => ['string']
        ]);
    }
}
