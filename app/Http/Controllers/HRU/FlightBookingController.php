<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class FlightBookingController extends Controller
{
    public function create(Request $request)
    {
        $employees = Employee::query()
            ->orderBy('lastname')
            ->active()
            ->get()
            ->map(function ($employee){
                return [
                    'id' => $employee->slug,
                    'text' => $employee->full['LFEMi'],
                    'birthday' => $employee->date_of_birth,
                    'phone' => $employee->cell_no,
                    'email' => $employee->email,
                ];
            });
        return view('_hru.flight-booking.create')
            ->with([
                'employees' => json_encode($employees),
            ]);
    }
}