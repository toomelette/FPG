<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\FLIGHTS\FlightsRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function store(Request $request)
    {
        $user = Auth::user();
        $flight = new FlightsRequests();
        $flight->slug = Str::uuid();
        $flight->employee_slug = $user->employee->slug;
        $flight->requested_by = $user->employee->full['LFEMi'];
        $flight->phone = $request->phone;
        $flight->email = $request->email;
        $flight->pap_code = $request->pap_code;


        $flight->start_airport = $request->start_airport;
        $flight->departure = $request->departure_date.' '.$request->departure_time;
        $flight->departure_flight_no = strtoupper($request->departure_flight_no);
        if($request->with_layover){
            $flight->layover_airport = $request->layover_airport;
            $flight->layover_departure = $request->layover_date.' '.$request->layover_time;
            $flight->layover_flight_no = strtoupper($request->layover_flight_no);
        }
        $flight->end_airport = $request->end_airport;
        if(!empty($request->return_start_airport) && !empty($request->return_departure_date) && !empty($request->return_departure_time)){
            $flight->return_start_airport = $request->return_start_airport;
            $flight->return_departure = $request->return_departure_date.' '.$request->return_departure_time;
            $flight->return_departure_flight_no = strtoupper($request->return_departure_flight_no);

            if($request->return_with_layover){
                $flight->return_layover_airport = $request->return_layover_airport;
                $flight->return_layover_departure = $request->return_layover_date.' '.$request->return_layover_time;
                $flight->return_layover_flight_no = strtoupper($request->return_layover_flight_no);
            }
            $flight->return_end_airport = $request->return_end_airport;
        }

        $employees = Employee::query()->whereIn('slug',collect($request->passengers)->pluck('employee_slug')->toArray())->get();
        $passengersArray = [];
        foreach ($request->passengers as $passenger){
            $passengersArray[] = [
                'request_slug' => $flight->slug,
                'slug' => Str::random(),
                'employee_slug' => $passenger['employee_slug'],
                'employee_name' => $employees->where('slug',$passenger['employee_slug'])?->first()?->full['LFEMi'] ?? $passenger['employee_slug'],
                'employee_birthday' => $passenger['birthday'],
                'phone' => $passenger['phone'],
                'email' => $passenger['email'],
                'seat_preference' => $passenger['seat_preference'],
            ];
        }
        dd($flight,$passengersArray);


        dd($request->all());
    }
}