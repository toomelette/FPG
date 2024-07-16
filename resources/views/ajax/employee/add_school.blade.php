@php
    $educ = '';
    if(isset($data)){
        $educ = $data;
    }
@endphp
<tr>
    <td style="width: 15%; vertical-align: middle">
        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::select('level',[
                'label' => 'Level:',
                'options' => \App\Swep\Helpers\Helper::educationalLevels(),
                'cols' => 12,
                'is_multiple' => 1,
                'required' => 'required',
            ],$educ) !!}
        </div>
    </td>
    <td>
        <div class="row">

            {!! \App\Swep\ViewHelpers\__form2::textbox('school_name',[
                'label' => 'School:',
                'cols' => 4,
                'is_multiple' => 1,
            ],$educ) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('course',[
                'label' => 'Course:',
                'cols' => 4,
                'is_multiple' => 1,
            ],$educ) !!}
            {!! \App\Swep\ViewHelpers\__form2::textbox('date_from',[
                'label' => 'Date from:',
                'cols' => 2,
                'is_multiple' => 1,
            ],$educ) !!}
            {!! \App\Swep\ViewHelpers\__form2::textbox('date_to',[
                'label' => 'Date to:',
                'cols' => 2,
                'is_multiple' => 1,
            ],$educ) !!}
        </div>
        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('units',[
                'label' => 'Units Earned:',
                'cols' => 2,
                'is_multiple' => 1,
            ],$educ) !!}

            {!! \App\Swep\ViewHelpers\__form2::select('graduate_year',[
                'label' => 'Year Graduated:',
                'cols' => 3,
                'options' => 'year',
                'past' => 100,
                'future' => 0,
                'is_multiple' => 1,
            ],$educ) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('scholarship',[
                'label' => 'Scholarship:',
                'cols' => 7,
                'is_multiple' => 1,
            ],$educ) !!}
        </div>
    </td>
    <td style="width: 5%;vertical-align: middle">

    </td>
</tr>