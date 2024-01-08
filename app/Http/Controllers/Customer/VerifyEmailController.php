<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated customer's email address as verified.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function verify(Request $request): RedirectResponse
    {
        if (!$this->fulfill($request)){
            return back()->with('verified_status', 'failed');
        }

        return redirect(RouteServiceProvider::HOME)->with('verified_status', 'success');
    }

    /**
     * Determine if the customer is authorized to make this request.
     *
     * @param Request $request
     * @return bool
     */
    public function fulfill(Request $request): bool
    {
        if ($request->routeIs('customer.verification.verify')) {
            if (!auth('customer')->loginUsingId((int) $request->route('id')) ||
                !hash_equals(sha1($request->user('customer')->getEmailForVerification()), (string) $request->route('hash')))
            {
                return false;
            }
        }

        if ($request->user('customer')->hasVerifiedEmail()) {
            return false;
        }

        $request->user('customer')->markEmailAsVerified();

        event(new Verified($request->user('customer')));

        return true;

    }
}
