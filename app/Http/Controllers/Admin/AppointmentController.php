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
        $query = $request->except(['page', 'pageSize']);
        $pageSize = $request->get('pageSize') ?: 1;
        $items = Appointment::query();
        if ($query) {
            foreach ($query as $key => $value) {
                $items = $items->where($key, 'like', "%$value%");
            }
        }

        $items = $items->paginate($pageSize);
        $itemsCount = Appointment::all()->count();

        return view('admin.appointment.listing', [
            'items' => $items,
            'itemsCount' => $itemsCount,
            'query' => $query
        ]);
    }
}
