<?php


namespace App\Http\Controllers;


use App\Http\Requests\IpAddress\IpAddressFormRequest;
use App\Models\IpAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class IpAddressController extends Controller
{
    public function index(Request $request){
        if($request->ajax() && $request->has('draw')){
            $ips = IpAddress::query();
            return DataTables::of($ips)
                ->addColumn('action',function($data){
                    return view('_mis.ip-address.dtActions')->with([
                        'data' => $data
                    ]);
                })
                ->escapeColumns([])
                ->setRowId('slug')
                ->toJson();
        }
        return view('_mis.ip-address.index');
    }

    public function store(IpAddressFormRequest $request){
        if($this->checkIpDuplicate($request) == true){
            abort(503,'Duplicate IP Address found.');
        }
        $ip = new IpAddress();
        $ip->slug = Str::random();
        $ip->user = $request->user;
        $ip->employee_no = $request->employee_no;
        $ip->property_no = $request->property_no;
        $ip->location = $request->location;
        $ip->octet_1 = $request->octet_1;
        $ip->octet_2 = $request->octet_2;
        $ip->octet_3 = $request->octet_3;
        $ip->octet_4 = $request->octet_4;
        $ip->ip_address = $ip->octet_1.'.'.$ip->octet_2.'.'.$ip->octet_3.'.'.$ip->octet_4;
        if($ip->save()){
            return $ip->only('slug');
        }
        abort(503,'Error saving data.');
    }

    public function edit($slug){
        $ip = $this->findBySlug($slug);
        return view('_mis.ip-address.edit')->with([
            'ip' => $ip,
        ]);
    }

    public function update(IpAddressFormRequest $request,$slug){
        if($this->checkIpDuplicate($request, $slug) == true){
            abort(503,'Duplicate IP Address found.');
        }
        $ip = $this->findBySlug($slug);
        $ip->user = $request->user;
        $ip->employee_no = $request->employee_no;
        $ip->property_no = $request->property_no;
        $ip->location = $request->location;
        $ip->octet_1 = $request->octet_1;
        $ip->octet_2 = $request->octet_2;
        $ip->octet_3 = $request->octet_3;
        $ip->octet_4 = $request->octet_4;
        $ip->ip_address = $ip->octet_1.'.'.$ip->octet_2.'.'.$ip->octet_3.'.'.$ip->octet_4;
        if($ip->save()){
            return $ip->only('slug');
        }
        abort(503,'Error saving data.');
    }

    private function findBySlug($slug){
        $ip = IpAddress::query()->where('slug','=',$slug)->first();
        return $ip ?? abort(503,'Data not found.');
    }

    public function destroy($slug){
        $ip = $this->findBySlug($slug);
        if($ip->delete()){
            return 1;
        }
        abort(503,'Error deleting item.');
    }

    private function checkIpDuplicate($request,$slug = null){
        $ipFull = $request->octet_1.'.'.$request->octet_2.'.'.$request->octet_3.'.'.$request->octet_4;
        $ip = IpAddress::query()
            ->where('ip_address','=',$ipFull);
        if($slug != null){
            $ip = $ip->where('slug','!=',$slug);
        }
        $ip = $ip->first();

        if(empty($ip)){
            return false;
        }
        return true;
    }

    public function show($slug){
        if($slug == 'map'){
            $ips = IpAddress::query()->get();
            $ipsArray = [];
            $duplicates = [];
            foreach ($ips as $ip){
                if(isset($ipsArray[$ip->octet_1][$ip->octet_2][$ip->octet_3][$ip->octet_4])){
                    $duplicates[$ip->ip_address] = $ip;
                }else{
                    $ipsArray[$ip->octet_1][$ip->octet_2][$ip->octet_3][$ip->octet_4] = $ip;
                }
            }

            return view('dashboard.ip_address.map')->with([
                'ips' => $ipsArray,
                'duplicates' => $duplicates,
            ]);
        }
    }
}