@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'employees-form-'.$rand,
    'slug' => request()->route('deduction_registry'),
])

@section('modal-header')
    Employees - {{request()->route('deduction_registry')}}
@endsection

@section('modal-body')
    <div class="row">
        <x-forms.input label="Search for employee" id="search-{{$rand}}" name="" cols="12 pb-3"/>
    </div>
    <div style="overflow-y: scroll; height:65vh" id="employee-list-container">

        <table id="employees-tbl-{{$rand}}" class="table table-bordered table-sm">
            <thead>
            <tr>
                <th style="width: 20px">
                    <label>
                        <input id="overall-selector-{{$rand}}" type="checkbox">
                    </label>
                </th>
                <th>Employee Name</th>
            </tr>
            </thead>
            <tbody>
            @forelse($employees as $employee)
                <tr>
                    <td>
                        <label>
                            <input class="employee-selector-{{$rand}}" type="checkbox" name="employees[]" value="{{$employee->slug}}" {{$employeesUsingDeduction->where('slug',$employee->slug)->count() > 0 ? 'checked' : ''}}>
                        </label>
                    </td>
                    <td>{{$employee->full['LFEMi']}}</td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>

    </div>

@endsection

@section('modal-footer')
    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Save</button>
@endsection

@section('scripts')
    <script type="text/javascript">

        $("#overall-selector-{{$rand}}").iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass   : 'iradio_flat-green'
        })
        $('.employee-selector-{{$rand}}').iCheck({
            checkboxClass: 'icheckbox_flat-blue checkbox-counter',
            radioClass   : 'iradio_flat-green'
        })

        $("body").on('ifUnchecked','#overall-selector-{{$rand}}',function (event){
            $('.employee-selector-{{$rand}}').iCheck('uncheck');
        })
        $("body").on('ifChecked','#overall-selector-{{$rand}}',function (event){
            $('.employee-selector-{{$rand}}').iCheck('check');
        })

        $("body").on('ifChanged','.employee-selector-{{$rand}}',function (event){
            setTimeout(function (){
                let selected = $(".checkbox-counter.checked").length;
                let total = $("#employees-tbl-{{$rand}} tbody tr").length;
                $("#checked").html(selected);
                if(selected === 0){
                    $("#overall-selector-{{$rand}}").iCheck('uncheck');
                }else if(selected === total){
                    $("#overall-selector-{{$rand}}").iCheck('check');
                }else{
                    $("#overall-selector-{{$rand}}").iCheck('indeterminate');
                }
            },100)
        });


        $("body").on('keyup','#search-{{$rand}}',function (){
            searchEmployee();
        });
        function searchEmployee() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search-{{$rand}}");
            filter = input.value.toUpperCase();
            table = document.getElementById("employees-tbl-{{$rand}}");
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

        $("#employees-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let uri = '{{route("dashboard.deduction_registry.update",request()->route('deduction_registry'))}}';
            uri = uri.replace('slug',form.attr('data'));
            loading_btn(form);
            $.ajax({
                url : uri,
                data : form.serialize(),
                type: 'PATCH',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    toast('info','Employee list successfully updated.','Updated');
                },
                error: function (res) {
                    errored(form,res);
                }
            })
        })
        $("#submit-{{$rand}}").click(function (){
            alert();
            $("#employees-form-{{$rand}}").submit();
        })
    </script>
@endsection