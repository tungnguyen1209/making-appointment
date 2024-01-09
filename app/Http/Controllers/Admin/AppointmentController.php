<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AppointmentController extends Controller
{
    /**
     * Display all appointments.
     */
    public function index(Request $request): View
    {
        $query = $request->all();
        $items = Appointment::all();
        if ($query) {
            foreach ($query as $key => $value) {
                if ($key == 'pageSize' || $key == 'page') {
                    continue;
                }

                $items = $items->where($key, $value);
            }
        }

        $itemsCount = $items->count();

        $items = $items->skip($request->get('pageSize') * ($request->get('page') - 1))
            ->take($request->get('pageSize'));

        return view('admin.appointment.listing', [
            'items' => $items,
            'itemsCount' => $itemsCount
        ]);
    }
}
