@php
    $elig = '';
    if(isset($data)){
        $elig = $data;
    }
@endphp
<tr>
    <td style="width: 20%; vertical-align: middle ">
        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('eligibility',[
                'label' => 'Eligibility:',
                'cols' => 12,
                'is_multiple' => 1,
                'required' => 'required'
            ],$elig) !!}
        </div>
    </td>
    <td>
        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('level',[
                'label' => 'Level:',
                'cols' => 3,
                'is_multiple' => 1,
            ],$elig) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('rating',[
                'label' => 'Rating:',
                'cols' => 3,
                'is_multiple' => 1,
            ],$elig) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('exam_place',[
                'label' => 'Place of Examination:',
                'cols' => 6,
                'is_multiple' => 1,
            ],$elig) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('exam_date',[
                'label' => 'Date of Examination:',
                'cols' => 4,
                'type' => 'date',
                'is_multiple' => 1,
            ],$elig) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('license_no',[
                'label' => 'License no:',
                'cols' => 4,
                'type' => 'date',
                'is_multiple' => 1,
            ],$elig) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('license_validity',[
                'label' => 'License Validity:',
                'cols' => 4,
                'type' => 'date',
                'is_multiple' => 1,
            ],$elig) !!}
        </div>
    </td>
    <td style="width: 5%; vertical-align: middle">

    </td>
</tr>