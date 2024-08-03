@extends('adminkit.master')

@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Daily Time Record</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div class="accordion accordion-sm mb-3">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        <i class="fas fa fa-filter"></i> Advanced Filters
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                    <div class="accordion-body">
                        <form id="filter_form">
                            <div class="row">
                                <div class="col-md-2 dt_filter-parent-div">
                                    <label>Status:</label>
                                    <select name="is_active"  class="form-control dt_filter filters">
                                        <option value="">Don't filter</option>
                                        {!! \App\Swep\Helpers\Helper::populateOptionsFromObject(\App\Models\SuOptions::employeeStatus(),'option','value') !!}
                                    </select>
                                </div>
                                <div class="col-md-2 dt_filter-parent-div">
                                    <label>Sex:</label>
                                    <select name="sex"  class="form-control dt_filter filter_sex filters select22">
                                        <option value="">Don't filter</option>
                                        <option value="MALE">Male</option>
                                        <option value="FEMALE">Female</option>
                                    </select>
                                </div>
                                <div class="col-md-2 dt_filter-parent-div">
                                    <label>Location:</label>
                                    <select name="locations"  class="form-control dt_filter filter_locations filters select22">
                                        <option value="">Don't filter</option>
                                        {!! \App\Swep\Helpers\Helper::populateOptionsFromObject(\App\Models\SuOptions::employeeGroupings(),'option','value') !!}
                                    </select>
                                </div>
                                <div class="col-md-2 dt_filter-parent-div">
                                    <label>Assignment:</label>
                                    <select name="assignment"  class="form-control dt_filter filter_sex filters select22">
                                        <option value="">Don't filter</option>
                                        <option value="OFFICE-BASED">OFFICE-BASED</option>
                                        <option value="FIELD">FIELD</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="dtr_table_container">
            <div class="table-responsive" >
                <table class="table table-bordered table-striped table-hover table-sm" id="dtr_table" style="width: 100%">
                    <thead>
                    <tr class="bg-green">
                        <th>Name</th>
                        <th>BM Id</th>
                        <th class="w-40">Employee No</th>
                        <th class="th-10">Locations</th>
                        <th class="th-10">Sex</th>
                        <th class="th-10">Last attendance</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </x-adminkit.html.card>
@endsection


@section('modals')


<x-adminkit.html.modal id="show_dtr_modal" size="lg"/>
<x-adminkit.html.modal id="dtr_modal" size="lg"/>

<div class="modal fade" id="print_dtr_modal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="print_dtr_form">
                <div class="modal-header">
                    <h5 class="modal-title">Print DTR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input name="month" hidden>
                        <input name="bm_u_id" hidden>
                        {!! \App\Swep\ViewHelpers\__form2::textbox('official_name',[
                            'label' => 'Authorized Official:',
                            'cols' => 12,
                            'required' => 'required',
                        ]) !!}
                        {!! \App\Swep\ViewHelpers\__form2::textbox('official_position',[
                            'label' => 'Position:',
                            'cols' => 12,
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script type="text/javascript">
        function dt_draw() {
            users_table.draw(false);
        }

        function filter_dt() {
            var sex = $(".filter_sex").val();
            var status = $(".filter_status").val();
            dtr_tbl.ajax.url("{{ route('dashboard.dtr.index') }}" + "?sex=" + sex + "&status=" + status).load();

            $(".filters").each(function (index, el) {
                if ($(this).val() != '') {
                    $(this).parent("div").addClass('has-success');
                    $(this).siblings('label').addClass('text-green');
                } else {
                    $(this).parent("div").removeClass('has-success');
                    $(this).siblings('label').removeClass('text-green');
                }
            });
        }
    </script>
    <script type="text/javascript">
        //-----DATATABLES-----//
        modal_loader = $("#modal_loader").parent('div').html();
        //Initialize DataTable
        active = '';
        dtr_tbl = $("#dtr_table").DataTable({
          'dom' : 'lBfrtip',
          "processing": true,
          "serverSide": true,
          "ajax" : '{{route('dashboard.dtr.index')}}',
          "columns": [
            { "data": "fullname" },
            { "data": "biometric_user_id" },
            { "data": "employee_no" },
            { "data": "locations"},
            { "data": "sex" },
            { "data": "last_attendance" },
              { "data": "action" }
          ],
          "buttons": [
            {!! __js::dt_buttons() !!}
          ],
          "columnDefs":[

            {
              "targets" : [,3,4],
              // "orderable" : ,
              "class" : 'w-6p'
            },
            {
                "targets" : [1,2],
              "class" : 'action-10p'
            },
            {
              "targets" : 6,
              "orderable" : false,
              "class" : 'action2'
            },
          ],
          "responsive": true,
          "initComplete": function( settings, json ) {
                  setTimeout(function () {
                      $("#filter_form select[name='is_active']").val('ACTIVE');
                      $("#filter_form select[name='is_active']").trigger('change');
                  },100);

                $('#tbl_loader').fadeOut(function(){
                  $("#dtr_table_container").fadeIn();
                });

          },


          "drawCallback": function(settings){
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="modal"]').tooltip();
            if(active != ''){
              $("#dtr_table #"+active).addClass('success');
            }
          }
        })
        
        style_datatable("#dtr_table");
        
        //Need to press enter to search
        $('#dtr_table_filter input').unbind();
        $('#dtr_table_filter input').bind('keyup', function (e) {
          if (e.keyCode == 13) {
            dtr_tbl.search(this.value).draw();
          }
        });

        $(".dt_filter").change(function () {
            filterDT(dtr_tbl);
        })
        $("body").on("click",'.show_dtr_btn',function () {
            btn = $(this);
            load_modal2(btn);
            url = '{{route("dashboard.dtr.show","slug")}}';
            url = url.replace("slug",btn.attr('data'));
            $.ajax({
                url : url,
                data : '',
                type: 'GET',
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    populate_modal2(btn,res);
                    console.log(res);
                },
                error: function (res) {
                    notify('Error','danger');
                    console.log(res);
                }
            })
        })

        $("#print_dtr_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let month = form.find('input[name=month]').val();
            let bm_u_id = form.find('input[name=bm_u_id]').val();
            let href = '{{route("dashboard.dtr.download")}}?'+form.serialize();
            // $("#print_frame").attr('src',);
            window.open(href, "popupWindow", "width=1200, height=600, scrollbars=yes");
            let sw = Swal.fire({
                icon: 'info',
                title: 'Please wait...',
                html: '<div style="padding: 15px; font-size: larger"><i class="fa fa-spin fa-spinner"></i> Preparing your DTR. . .</div>',
                showConfirmButton : false,
            });

            setTimeout(function (){
                sw.close();
            },1000);
        })
    </script>

@endsection