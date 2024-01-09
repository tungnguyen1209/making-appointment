<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display all customers.
     */
    public function index(): View
    {
        $items = Customer::all();
        $itemsCount = $items->count();

        return view('admin.customer.listing', [
            'items' => $items,
            'itemsCount' => $itemsCount
        ]);
    }
}
