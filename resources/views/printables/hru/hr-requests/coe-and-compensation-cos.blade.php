@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; font-size: 16px; margin: 170px 40px 0px 40px">
        <small>MEMO-VIS-AFD-GAD-HRRS-{{Carbon::parse($hrRequest->document_fields['date'])->format('Y')}}-{{$hrRequest->document_fields['memo_code']}}</small>
        <br>
        <br>
        <br>
        <p class="text-strong text-center" style="letter-spacing: 4px; font-size: 18px">CERTIFICATION</p>
        <br><br>
        {!!  Str::of($hrRequest->document_fields['first_paragraph'])->replaceFirst('<p>','<p style="text-indent: 40px; line-height: 35px; text-align: justify">') !!}

                <br>
        {!!  Str::of($hrRequest->document_fields['purpose_paragraph'])->replaceFirst('<p>','<p style="text-indent: 40px; line-height: 35px; text-align: justify">') !!}

        <br>
        <p style="text-indent: 40px; line-height: 35px; text-align: justify">
            Done in the City of {{\App\Swep\Helpers\Get::headerCity()}}, this {{Helper::ordinal(Carbon::parse($hrRequest->document_fields['date'])->format('d'))}} of {{Carbon::parse($hrRequest->document_fields['date'])->format('F, Y')}}.
        </p>
        <br>
        <div style="overflow: auto">
            <div style="width: 50%; float: right">
                <p class="text-center">
                    <b>{{$hrRequest->document_fields['signatory_name']}}</b>
                    <br>
                    {{$hrRequest->document_fields['signatory_position']}}
                </p>
            </div>
        </div>


        <br><br><br><br>

        <div style="display:none;">
            <p class="no-margin text-right" style="font-size: 10px; font-style: italic">FM-AFD-HRS-036, Rev. 00</p>
            <p class="no-margin text-right" style="font-size: 10px; font-style: italic">Effectivity Date: March 12, 2015</p>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        @if(\Illuminate\Support\Facades\Request::has('autoPrint') && \Illuminate\Support\Facades\Request::get('autoPrint') == true)
        print();
        @endif
    </script>
@endsection