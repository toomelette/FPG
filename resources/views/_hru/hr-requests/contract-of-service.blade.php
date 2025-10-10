@php
    $rand = Str::random();
@endphp
@extends('adminkit.modal',[
    'id' => 'edit-cos-form-'.$rand,
    'slug' => $hrRequest->slug,
])

@section('modal-header')
Create Contract of Service
@endsection

@section('modal-body')
    <div class="row mb-2">
        <x-forms.input label="MEMO Code" name="memo_code" cols="12" :value="$settings['memo_code'] ?? null"/>
        <x-forms.input label="Val" name="value" cols="12" container-class="hide-this" :value="1"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Contract Start" name="contract_start" cols="6" type="date" :value="$settings['contract_start'] ?? null"/>
        <x-forms.input label="Contract End" name="contract_end" cols="6" type="date" :value="$settings['contract_end'] ?? null"/>
    </div>
    <div class="row mb-2">
        <x-forms.input label="Position" name="position" cols="6" :value="$hrRequest->employee->position ?? null"/>
        <x-forms.input label="Salary" name="salary" cols="6" class="autonum-{{$rand}}" :value="$hrRequest->employee->monthly_basic ?? null"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Department" name="department" cols="12" :value="strtoupper($hrRequest?->employee?->responsibilityCenter?->description?->descriptive_name)"/>
    </div>
    @php
        $assignment = '';
        $rc = $hrRequest?->employee?->responsibilityCenter;
        $dept = $rc?->description?->descriptive_name;
        $div = $hrRequest?->employee?->responsibilityCenter?->division;
        $sec = $hrRequest?->employee?->responsibilityCenter?->section;
        if (!empty($dept)){
            $assignment .= strtoupper($dept);
        }
        if (!empty($div)){
            $assignment .= ' - '. $div;
        }
        if (!empty($sec)){
            $assignment .= ' - '. $sec;
        }
    @endphp
    <div class="row mb-2">
        <x-forms.textarea label="Assignment" name="assignment" cols="12" :value="$assignment"/>
    </div>

    <div class="row mb-2">
        <x-forms.input label="Funds Available" name="funds_available" cols="6" :value="Str::upper($settings['funds_available'] ?? null)"/>
        <x-forms.input label="Funds Available" name="funds_available_position" cols="6" :value="Str::upper($settings['funds_available_position'] ?? null)"/>
    </div>
@endsection

@section('modal-footer')
    <button class="btn btn-sm btn-primary" type="submit"><i class="fas fa-thumbs-up"></i> Approve Contract of Service</button>
@endsection

@section('scripts')
    <script type="text/javascript">
        AutoNumeric.multiple('.autonum-{{$rand}}', {
            decimalPlaces: 2,
            digitGroupSeparator: ','
        });

        $("#edit-cos-form-{{$rand}}").submit(function (e) {
            e.preventDefault();
            let form = $(this);
            loading_btn(form);
            let uri = '{{route('dashboard.hr_requests.update',$hrRequest->slug)}}';
            $.ajax({
                url : uri,
                type: 'PATCH',
                data : form.serialize(),
                headers: {
                    {!! __html::token_header() !!}
                },
                success: function (res) {
                    succeed(form,true,true);
                    active = res.slug;
                    requestsTbl.draw(false);
                    toast('info','Updated successfully.','Success');
                },
                error: function (res) {
                    populate_modal2_error(res);
                    errored(form,res);
                }
            })
        })
    </script>
@endsection