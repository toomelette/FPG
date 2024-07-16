@php
    $we = '';
    if(isset($data)){
        $we = $data;
    }

    if(isset($rand)){
        $rand = $rand;
    }else{
        $rand = '';
    }
@endphp
<tr>
    <td style="width: 20%; vertical-align: middle ">
        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('company',[
                'label' => 'Company:',
                'cols' => 12,
                'is_multiple' => 1,
                'required' => 'required'
            ],$we) !!}
        </div>
    </td>
    <td>
        <div class="row">
            {!! \App\Swep\ViewHelpers\__form2::textbox('date_from',[
                'label' => 'Date from:',
                'cols' => 3,
                'type' => 'date',
                'is_multiple' => 1,
            ],$we) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('date_to',[
                'label' => 'Date to:',
                'cols' => 3,
                'type' => 'date',
                'is_multiple' => 1,
            ],$we) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('position',[
                'label' => 'Position:',
                'cols' => 6,
                'is_multiple' => 1,
            ],$we) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('salary',[
                'label' => 'Salary:',
                'cols' => 4,
                'is_multiple' => 1,
                'class' => 'we_salary'.$rand,
            ],$we) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('salary_grade',[
                'label' => 'Salary Grade:',
                'cols' => 2,
                'type' => 'number',
                'is_multiple' => 1,
            ],$we) !!}

            {!! \App\Swep\ViewHelpers\__form2::textbox('appointment_status',[
                'label' => 'Appointment Status:',
                'cols' => 3,
                'is_multiple' => 1,
            ],$we) !!}

            {!! \App\Swep\ViewHelpers\__form2::select('is_gov_service',[
                'label' => 'Gov. Service?:',
                'cols' => 3,
                'options' => ['YES'=> 'YES', 'NO' => 'NO'],$we,
                'is_multiple' => 1,
            ],$we) !!}

        </div>
    </td>
    <td style="width: 5%; vertical-align: middle">

    </td>
</tr>