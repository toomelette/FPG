@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; font-size: 16px; margin: 180px 40px 0px 40px">
        <small>MEMO-VIS-AFD-GAD-HRRS-{{Carbon::parse($hrRequest->document_fields['date'])->format('Y')}}-{{$hrRequest->document_fields['memo_code']}}</small>
        <br><br><br>

        <h3 class="text-center text-strong">CERTIFICATE OF ASSUMPTION</h3>

        <br><br>
        {!!  Str::of($hrRequest->document_fields['first_paragraph'])->replaceFirst('<p>','<p style="text-indent: 40px; line-height: 35px; text-align: justify">') !!}

        <table style="width: 100%; font-size: 16px;margin-top: 60px">
        <tr>
            <td style="width: 50%;"></td>
            <td class="text-center">
                <b>{{$hrRequest->document_fields['signatory_name_0']}}</b><br>
                {{$hrRequest->document_fields['signatory_position_0']}}
            </td>
        </tr>
            <tr>
                <td class="">
                    Attested by:<br><br><br>
                    <b>{{$hrRequest->document_fields['signatory_name']}}</b><br>
                    {{$hrRequest->document_fields['signatory_position']}}
                </td>
                <td>

                </td>
            </tr>
        </table>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        @if(\Illuminate\Support\Facades\Request::has('autoPrint') && \Illuminate\Support\Facades\Request::get('autoPrint') == true)
        print();
        @endif
    </script>
@endsection