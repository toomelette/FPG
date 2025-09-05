@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div style="font-family: Cambria; font-size: 16px; margin: 180px 40px 0px 40px">
        <small>MEMO-VIS-AFD-GAD-HRRS-{{Carbon::parse($hrRequest->document_fields['date'])->format('Y')}}-{{$hrRequest->document_fields['memo_code']}}</small>
        <br><br><br>

        {{ Helper::dateFormat($hrRequest->document_fields['date'],'F d, Y') }}
        <br><br>
        {!! $hrRequest->document_fields['address_to'] !!}

        {!!  Str::of($hrRequest->document_fields['body'])->replaceFirst('<p>','<p style="text-indent: 40px; line-height: 25px; text-align: justify">') !!}

        <p style="text-indent: 40px; line-height: 35px; text-align: justify">
            Thank you very much.
        </p>
        <br><br>
        Sincerely yours,
        <br><br><br>
        {!! $hrRequest->document_fields['hr_representative'] !!}
        <br>
        Noted by:
        <br><br><br>
        {!! $hrRequest->document_fields['hr_representative'] !!}
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        @if(\Illuminate\Support\Facades\Request::has('autoPrint') && \Illuminate\Support\Facades\Request::get('autoPrint') == true)
        print();
        @endif
    </script>
@endsection