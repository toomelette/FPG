@php
    $bday_mark = '';
    $bday = 'N/A';
    if($data->date_of_birth != '' ){
        if(Carbon::parse($data->date_of_birth)->format("md") == Carbon::now()->format('md')){
            $bday_mark  = '<span style="padding-right:5px" class="pull-right text-danger"><i class="fa fa-birthday-cake" title="Today is '.ucfirst(strtolower($data->firstname)).'\'s birthday."></i></span>';
        }
        $bday = Carbon::parse($data->date_of_birth)->format("M. d, Y");
    }
@endphp

<p class="text-strong no-margin">
    {{$data->full['LFE']}} <span style="font-weight: normal">{{$data->middlename}}</span>

    @switch($data->locations)
        @case('RETIREE')
            <span class="badge bg-danger float-end">RETIREE</span>
            @break
        @case('JANITORIAL')
        @case('SECURITY')
            <span class="badge bg-warning float-end">{{Str::limit($data->locations,3,'')}}</span>
            @break
        @case('LUZON/MINDANAO')
        @case('COS-LUZMIN')
            <span class="badge bg-primary float-end">LM</span>
            @break
        @case('VISAYAS')
        @case('COS-VISAYAS')
            <span class="badge bg-success float-end">VIS</span>
            @break
        @default

            @break
    @endswitch
    {!! $bday_mark !!}
</p>
<div class="subdetail" style="margin-top: 3px">
    <table class="table-subdetail">
        <tr>
            <td style="padding-right: 10px">Bday:</td>
            <td>{{$bday}}</td>
            <td style="padding-left: 20px;padding-right: 10px">Age:</td>
            <td>{{Carbon::parse($data->date_of_birth)->age}}</td>
        </tr>

        <tr>
            <td style="padding-right: 10px">Sex:</td>
            <td>{{$data->sex}}</td>
            <td style="padding-left: 20px;padding-right: 10px">Civil Stat:</td>
            <td>{{$data->civil_status}}</td>
        </tr>
        <tr>
            <td style="padding-right: 10px">Phone : </td>
            <td>{{$data->cell_no}}</td>
            <td style="padding-left: 20px;padding-right: 10px">Email : </td>
            <td><a href="mailto:{{$data->email}}"> {{$data->email}}</a></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #e7e7e7 ;padding-right: 10px"><small>Created :</small> </td>
            <td style="border-top: 1px solid #e7e7e7"><small>{{Helper::dateFormat($data->created_at,'M. d, Y | h:i A')}}</small></td>
            <td style="border-top: 1px solid #e7e7e7 ;padding-left: 20px;padding-right: 10px"><small>Updated :</small> </td>
            <td style="border-top: 1px solid #e7e7e7"><small>{{Helper::dateFormat($data->updated_at,'M. d, Y | h:i A')}}</small></td>
        </tr>
    </table>

</div>
