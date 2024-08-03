<?php


namespace App\Http\Controllers;


use App\Http\Requests\Holiday\HolidayFormRequest;
use App\Models\Holiday;
use App\Models\SuSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class HolidayController extends Controller
{
    public function index(){
        if(request()->ajax()){
            if(request()->has('draw')){
                $holidays = Holiday::query();
                if(request()->has('year')){
                    if(request('year') != ''){
                        $holidays = $holidays->whereYear('date',request('year'));
                    }
                }

                return DataTables::of($holidays)
                    ->addColumn('year',function ($data){
                        return Carbon::parse($data->date)->format('Y');
                    })
                    ->addColumn('action',function ($data){
                        return view('_hru.holidays.dtActions')->with([
                            'data' => $data,
                        ]);
                    })
                    ->editColumn('date',function ($data){
                        return view('_hru.holidays.dtDate')->with([
                            'data' => $data,
                        ]);
                    })
                    ->escapeColumns([])
                    ->setRowId('slug')
                    ->toJson(true);
            }
        }

        return view('_hru.holidays.index');
    }

    public function fetchGoogleApi(){
        $api_key = '';
        $su_settings = SuSettings::query()->where('setting','=','google_calendar_api_key')->first();
        if(!empty($su_settings)){
            $api_key = $su_settings->string_value;
        }
        $url = 'https://www.googleapis.com/calendar/v3/calendars/en.philippines%23holiday%40group.v.calendar.google.com/events?key='.$api_key;
        $json = json_decode(file_get_contents($url),true);
        $response = response()->json($json);
        $response_data = $response->getData();

        foreach ($response_data->items as $item) {

            $hol = Holiday::query()->where('google_calendar_id','=' , $item->id)->first();
            $type = $item->description;
            if(strpos($item->description, 'Observance') !== false){
                $type = 'Observances';
            }
            if(!empty($hol)){
                $hol->date = $item->start->date;
                $hol->name = $item->summary;
                $hol->type = $type;
                $hol->google_calendar_id = $item->id;
                $hol->created_at = Carbon::now();
                $hol->update();
            }else{
                $holiday = new Holiday();
                $holiday->slug = Str::random(16);
                $holiday->date = $item->start->date;
                $holiday->name = $item->summary;
                $holiday->type = $type;
                $holiday->google_calendar_id = $item->id;
                $holiday->created_at = Carbon::now();
                $holiday->save();
            }
        }
        return 1;
    }

    public function store(HolidayFormRequest $request){
        $holiday = new Holiday;
        $holiday->slug = Str::random(16);
        $holiday->name = $request->name;
        $holiday->date = $request->date;
        $holiday->type = $request->type;

        if($holiday->save()){
            return $holiday->only('slug');
        }
        abort(503,'Error saving');
    }

    public function edit($slug){
        $holiday = Holiday::query()
            ->findOrFail($slug);
        if(!empty($holiday)){
            return view('_hru.holidays.edit')->with([
                'holiday' => $holiday,
            ]);
        }
        abort(503,'Data not found.');

    }

    public function update(HolidayFormRequest $request,$slug){
        $holiday = Holiday::query()->where('slug','=',$slug)->first();
        if(!empty($holiday)){
            $holiday->name = $request->name;
            $holiday->date = $request->date;
            $holiday->type = $request->type;
            if($holiday->update()){
                return $holiday->only('slug');
            }
            abort(503,'Error saving');
        }else{
            abort(503,'Data not found.');
        }
    }

    public function destroy($slug){
        $holiday = Holiday::query()->where('slug','=',$slug)->first();
        if(!empty($holiday)){
            if($holiday->delete()){
                return 1;
            }
            abort(503,'Error deleting');
        }else{
            abort(503,'Data not found.');
        }
    }
}