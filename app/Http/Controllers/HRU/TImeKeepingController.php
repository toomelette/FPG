<?php

namespace App\Http\Controllers\HRU;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hru\TimekeepingFormRequest;
use App\Models\DTR;
use App\Models\HRU\Timekeeping;
use App\Models\HRU\TimekeepingDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TImeKeepingController extends Controller
{
    public function create(Request $request)
    {
        if($request->ajax() && $request->has('getDtr') && $request->getDtr == true){
            $biometricUserId = \Auth::user()->employee->biometric_user_id;

            $dtrs = DTR::query()
                ->selectRaw('*, date_format(timestamp,"%Y-%m-%d") as date')
                ->where('user','=',$biometricUserId)
                ->where('timestamp','like',$request->month.'%')
                ->get();
            $daysInAMonth = Carbon::parse($request->month.'-01')->daysInMonth;
            return view('_hru.time-keeping.dtr-preview')->with([
                'dtrs' => $dtrs,
                'daysInAMonth' => $daysInAMonth,
                'month' => $request->month,
            ]);
        }
        return view('_hru.time-keeping.create');
    }

    public function store(TimekeepingFormRequest $request)
    {
        $user = \Auth::user();
        $tk = new Timekeeping();
        $tk->slug = Str::random();
        $tk->series = '2025-0001';
        $tk->employee_slug = $user->employee->slug;
        $tk->name = $user->employee->full['FMiLE'];
        $tk->resp_center = $user->employee->responsibilityCenter->desc ?? '-';
        $tk->position = $user->employee->plantilla->position ?? $user->employee->position;
        $tk->authorized_official = 'TEST';


        if(count($request->dates) > 0){
            $insertArr = [];
            foreach ($request->dates as $row){
                $insertArr[] = [
                    'timekeeping_slug' => $tk->slug,
                    'slug' => Str::random(),
                    'date' => $request->month.'-'.Str::padLeft($row['day'],2,'0'),
                    'am_in' => $row['am_in'],
                    'am_out' => $row['am_out'],
                    'pm_in' => $row['pm_in'],
                    'pm_out' => $row['pm_out'],
                ];
            }
        }
        if($tk->save()){
            TimekeepingDetails::query()->insert($insertArr);
            return $tk->only('slug');
        }
        abort(503,'Error creating timekeeping form.');

    }
}