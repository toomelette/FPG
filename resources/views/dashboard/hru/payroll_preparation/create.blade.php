@extends('layouts.admin-master')

@section('content')

@endsection
@section('content2')

    <section class="content">
        <form id="prepare_payroll_form">
            <div class="box box-solid">
                <div class="box-header">
                    Payroll Preparation
                    <button type="submit" class="pull-right btn btn-primary btn-sm"> <i class="fa fa-chevron-right"></i> Next </button>
                </div>
                <div class="box-body">
                    <div class="row">
                        {!! \App\Swep\ViewHelpers\__form2::textbox('date',[
                            'label' => 'Payroll Date:',
                            'cols' => 3,
                            'type' => 'date',
                        ]) !!}

                        {!! \App\Swep\ViewHelpers\__form2::select('type',[
                            'label' => 'Payroll Type:',
                            'cols' => 3,
                            'options' => \App\Swep\Helpers\Arrays::payrollTypes(),
                        ]) !!}
                    </div>
                    <input id="search">
                    <div style="overflow-y: scroll; height: calc(60vh - 3rem)">
                        <table class="table table-condensed table-striped table-hover" id="employees_table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Employee</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $employees = \App\Models\Employee::query()
                                    ->applyProjectId()
                                    ->active()
                                    ->permanent()
                                    ->orderBy('lastname','asc')
                                    ->get();
                            @endphp
                            @forelse($employees as $employee)
                                <tr>
                                    <td>
                                        <label>
                                            <input class="emp_selector" type="checkbox" checked name="employees[]" value="{{$employee->slug}}">
                                        </label>
                                    </td>
                                    <td>{{$employee->full_name}}</td>
                                </tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </form>
    </section>

@endsection


@section('modals')
@endsection


@section('scripts')
    <script type="text/javascript">

        $("#prepare_payroll_form").submit(function (e) {
            e.preventDefault()
            let form = $(this);
            loading_btn(form);
            $.ajax({
                url : '{{route("dashboard.payroll_preparation.store")}}',
                data : form.serialize(),
                type: 'POST',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    toast('success','Please wait for a while while. Redirecting...','Success!');
                    let url = '{{route("dashboard.payroll_preparation.edit","slug")}}';
                    url = url.replace('slug',res.slug);
                    window.location.href = url;
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("#search").keyup(function (){
            myFunction();
        });
        function myFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("employees_table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

    </script>
@endsection