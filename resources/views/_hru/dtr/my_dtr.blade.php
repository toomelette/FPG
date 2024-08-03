@php
    $bm_uid = 0;

    if(!empty($employee->biometric_user_id)){
        $bm_uid = $employee->biometric_user_id;
    }
@endphp
@extends('adminkit.master')
@section('content2')
    <x-adminkit.html.page-title>
        <x-slot:title>Daily Time Record</x-slot:title>
    </x-adminkit.html.page-title>
    <x-adminkit.html.card>
        <div class="accordion" id="accordionExample">

            @foreach($dtr_by_year as $key => $months)
                @php(arsort($months))

                @php($must_be_last = \Illuminate\Support\Str::after(array_key_first($months),'-')*1)
                @for($x = 1 ; $x <= $must_be_last; $x++)
                    @if(!isset($dtr_by_year[$key][$key.'-'.str_pad($x,2,'0',STR_PAD_LEFT)]))
                        @php($dtr_by_year[$key][$key.'-'.str_pad($x,2,'0',STR_PAD_LEFT)] = '')
                    @endif
                @endfor

            @endforeach


            @if(count($dtr_by_year) > 0)
                @php($num=0)
                @foreach($dtr_by_year as $key => $months)
                    @php(ksort($months))
                    @php($num++)
                    @if($num == 1)

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                    {{$key}}
                                </button>
                            </h2>
                            <div id="collapse{{$key}}" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    @if(count($months) > 0)
                                        @php(ksort($months))
                                        <div class="row">
                                            @foreach($months as $month => $null)
                                                <div class="{{$col}}">
                                                    @if(\Carbon\Carbon::parse($month)->format('Y-m') == \Carbon\Carbon::now()->format('Y-m'))
                                                        @php($class = 'btn-success')
                                                    @else
                                                        @php($class = 'btn-outline-primary')
                                                    @endif
                                                    <button style="width: 100%;" class="btn {{$class}} month_btn mb-2" data-bs-toggle="modal" data-bs-target="#dtr_modal" month="{{$month}}">{{strtoupper(\Carbon\Carbon::parse($month)->format('M'))}}</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @else

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                    {{$key}}
                                </button>
                            </h2>
                            <div id="collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    @if(count($months) > 0)
                                        @php(ksort($months))
                                        <div class="row">
                                            @foreach($months as $month => $null)
                                                <div class="{{$col}}">
                                                    <button style="width: 100%;" class="btn btn-outline-primary month_btn mb-2" data-bs-toggle="modal" data-bs-target="#dtr_modal" month="{{$month}}">{{strtoupper(\Carbon\Carbon::parse($month)->format('M'))}}</button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                    @endif
                @endforeach


            @else
                <div class="callout callout-success">
                    <h4><i class="fa fa-info-circle"></i> No attendance record found.</h4>
                </div>
            @endif

        </div>
    </x-adminkit.html.card>


@endsection


@section('modals')

    <x-adminkit.html.modal id="dtr_modal" size="lg"/>
    <div class="modal fade" id="print_dtr_modal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="print_dtr_form">
                    <div class="modal-header">
                        <h5 class="modal-title">Default modal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input name="month" hidden>
                            <input name="bm_u_id" hidden>
                            <x-forms.input label="Authorized Official" name="official_name" cols="12" required="required" container-class="mb-1"/>
                            <x-forms.input label="Position Official" name="official_position" cols="12" required="required" container-class="mb-1"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa fa-print"></i> Print</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="print_dtr_modal" tabindex="-1" role="dialog" aria-labelledby="print_dtr_modal_label">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form id="print_dtr_form">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Print DTR</h4>
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
            is_online = $(".filter_status").val();
            is_active = $(".filter_account").val();
            users_table.ajax.url("{{ route('dashboard.user.index') }}" + "?is_online=" + is_online + "&is_active=" + is_active).load();

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
        modal_loader = $("#modal_loader").parent('div').html();
        $(document).ready(function () {



        })
        $('body').on('click','.month_btn',function () {
            btn = $(this);
            var month = $(this).attr('month');
            var bm_u_id = "{{$bm_uid}}";
            load_modal2(btn);
            $.ajax({
                url : '{{route("dashboard.dtr.fetch_by_user_and_month")}}',
                data : {bm_u_id : bm_u_id, month: month},
                type: 'GET',
                success: function (res) {
                   populate_modal2(btn,res);
                },
                error: function (res) {
                    populate_modal2_error(res);
                }
            })
        })

        $("body").on("click",".fc-day-grid-event",function (e) {
            e.preventDefault();
            if($(this).attr('href') != 'undefined' && $(this).attr('href') !== false){
                Swal.fire(
                    'Details:',
                    $(this).attr('href'),
                    'info',
                )
            }
        })

        $("#capture_btn").click(function () {
            html2canvas(document.querySelector(".box-success")).then(canvas => {
                $('#frameee').append(canvas);
            });
        });
        $("#print_dtr_form").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            let month = form.find('input[name=month]').val();
            let bm_u_id = form.find('input[name=bm_u_id]').val();
            let href = '{{route("dashboard.dtr.download")}}?'+form.serialize();
            //$("#print_frame").attr('src','{{route("dashboard.dtr.download")}}?'+form.serialize());
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