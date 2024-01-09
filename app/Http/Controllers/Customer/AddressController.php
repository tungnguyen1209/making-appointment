<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AddressController extends Controller
{
    /**
     * Display the customer's addresses.
     */
    public function index(Request $request): View
    {
        $items = $request->user('customer')->getAddresses()->getResults();
        $itemsCount = $items->count();

        return view('customer.address.listing', [
            'items' => $items,
            'itemsCount' => $itemsCount
        ]);
    }

    /**
     * Create the customer's address.
     */
    public function create(Request $request): RedirectResponse
    {
        try {
            $this->validateRequest($request);

            $addressData = [
                'customer_id' => $request->user('customer')->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'details' => $request->details
            ];

            CustomerAddress::query()->create($addressData);

            return redirect('/address')->with('success', __('Address Created Successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the customer's address form.
     */
    public function view(Request $request): View
    {
        $address = CustomerAddress::query()->findOrFail($request->id);

        return view('customer.address.view', [
            'address' => $address,
        ]);
    }

    /**
     * Update the customer's address information.
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $this->validateRequest($request);
            $address = CustomerAddress::query()->findOrFail($request->id);
            $address->fill($request->all());
            $address->save();

            return Redirect::route('customer.address.view', ['id' => $request->id])->with('success', __('Address Updated Successfully'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete the customer's address.
     */
    public function delete(Request $request): RedirectResponse
    {
        try {
            $address = CustomerAddress::query()->findOrFail($request->id);
            $address->delete();

            return Redirect::to('/address')->with('success', __('Address Deleted Successfully'));
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'phone' => ['required', 'digits_between:10,11'],
            'details' => ['required', 'string']
        ]);
    }
}
