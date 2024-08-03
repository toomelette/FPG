@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <div class="text-center">
        <h2>{{$employee->lastname}}, {{$employee->firstname}} {{$employee->middlename}}</h2>
        <h3 class="no-margin">Birthday: {{Carbon::parse($employee->date_of_birth)->format('F d, Y')}}</h3>
        <h3 class="no-margin">Age: {{Carbon::parse($employee->date_of_birth)->age}}</h3>
        <h3 class="no-margin">Position: {{$employee->position}}</h3>
        <br>
        <h3 class="no-margin">{{$employee->employee_no}}</h3>
        <br>
        <img src="{{route('dashboard.employee.generate_qr',$employee->slug)}}?get_qr=1">

        <br><br>
        @php
            $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        @endphp
        <img src="data:image/png;base64,{{base64_encode($generator->getBarcode($employee->employee_no, $generator::TYPE_CODE_128))}}">
    </div>
@endsection

@section('scripts')

@endsection