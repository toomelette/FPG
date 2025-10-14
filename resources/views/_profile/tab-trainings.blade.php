<div class="card">
    <div class="card-body">
        <h5 class="card-title">Trainings</h5>
        <table class="table table-striped table-bordered table-sm">
            <thead>
            <tr>
                <th style="width: 50%">Title</th>
                <th>Started</th>
                <th>Ended</th>
                <th>Detailed Period</th>
            </tr>
            </thead>
            <tbody>
            @php
                $trainings = $employee->employeeTraining->sortByDesc('sequence_no');
            @endphp
            @forelse($trainings as $training)
                <tr>
                    <td>{{$training->title}}</td>
                    <td>{{Helper::dateFormat($training->date_from,'M. d, Y')}}</td>
                    <td>{{Helper::dateFormat($training->date_to,'M. d, Y')}}</td>
                    <td>{{$training->detailed_period}}</td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
    </div>
</div>