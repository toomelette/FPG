@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    @if($cosEmps->count() > 1)
        <div style="break-after: page; font-family: Cambria;">
            <b>Summary of Contracts attached:</b>
            <table style="width: 100%;" class="tbl tbl-padded tbl-bordered-grey">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Emp. No.</th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Position</th>
                    <th class="text-center">Resp Center</th>
                    <th class="text-center">Eval</th>
                    <th class="text-center">Salary</th>
                </tr>
                </thead>
                @forelse($cosEmps as $cosEmp)
                    <tr>
                        <td class="text-right">{{$loop->iteration}}</td>
                        <td>{{$cosEmp->employee->employee_no}}</td>
                        <td>{{$cosEmp->employee_fullname}}</td>
                        <td>{{$cosEmp->employee->position}}</td>
                        <td>{{$cosEmp->employee->responsibilityCenter->desc}}</td>
                        <td class="text-center">
                            @if($cosEmp->evaluation_path !== null)
                                ✔
                            @endif
                        </td>
                        <td class="text-right">{{number_format($cosEmp->employee->monthly_basic,2)}}</td>
                    </tr>
                @empty
                @endforelse
            </table>
        </div>

    @endif
@endsection

@section('scripts')
    <script type="text/javascript">

    </script>
@endsection