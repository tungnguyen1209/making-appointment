<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('customer.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        if (!Auth::guard('customer')->validate([
            'email' => $request->user('customer')->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('customer.password'),
            ]);
        }

        $request->session()->put('customer.password_confirmed_at', time());

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
