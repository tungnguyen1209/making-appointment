<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Repository\Customer as CustomerRepository;

class RegisteredCustomerController extends Controller
{
    /**
     * @var CustomerRepository
     */
    protected CustomerRepository $customerRepository;

    /**
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('customer.register');
    }

    /**
     * Handle an incoming registration request.
     *
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:customers'],
            'phone' => ['required', 'digits_between:10,11', 'unique:customers,phone'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $customer = $this->customerRepository->create($request->all());

        event(new Registered($customer));

        Auth::guard('customer')->login($customer);

        return redirect(RouteServiceProvider::HOME);
    }
}
