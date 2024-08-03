<div class="row">
    <div class="col-md-6">
        <h4>DTR covering the period of <b>{{Carbon::parse($date_range[0])->format('F, Y')}}</b></h4>
    </div>
    <div class="col-md-6">
        <button class="btn btn-primary pull-right" style="margin-bottom: 2rem" device="" onclick="saveAttendance('{{$device}}')">
            <i class="fa fa-save"></i> Save Attendance
        </button>
    </div>
</div>


<table class="table table-bordered" id="attendance_table">
    <thead>
        <tr>
            <th>UID</th>
            <th>Employee</th>
            <th>Type</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
        @if(count($attendance) > 0)
            @foreach($attendance as $key=>$data)
                <tr id="{{$data['uid']}}">
                    <td>{{$data['uid']}}</td>
                    <td>{{$data['id']}}</td>
                    <td>{!! \App\Swep\ViewHelpers\__html::dtr_type_badge($data['type'])!!}</td>
                    <td>{{$data['timestamp']}}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>