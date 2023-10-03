<tr id="row_{{$slug}}">
    <td>
        {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details['.$slug.'][account]',[
            'class' => 'input-sm account',
            'readonly' => 'readonly',
            'copyNameToClass' => 1,
        ],$jevDetail->account_code ?? null) !!}
    </td>
    <td>
        {!! \App\Swep\ViewHelpers\__form2::selectOnly('jev_details['.$slug.'][account_code]',[
            'class' => 'input-sm select2_account_code '.(!empty($jevDetail) ? 'init_select2_account_code' : ''),
            'options' => [],
            'container_class' => 'select2-sm',
            'copyNameToClass' => 1,
            'select2_preSelected' => ($jevDetail->chartOfAccount->account_title ?? '').' - '.($jevDetail->account_code ?? ''),
        ],$jevDetail->account_code ?? null) !!}
    </td>
    <td>
        {!! \App\Swep\ViewHelpers\__form2::selectOnly('jev_details['.$slug.'][resp_center]',[
            'class' => 'input-sm select2-sm select2_resp_center '.(!empty($jevDetail) ? 'init_select2_resp_center' : ''),
            'options' => \App\Swep\Helpers\Arrays::departmentListAbbv(),
            'container_class' => 'select2-sm',
            'copyNameToClass' => 1,
        ],$jevDetail->resp_center ?? null) !!}
    </td>
    <td>
        {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details['.$slug.'][debit]',[
            'class' => 'input-sm text-right autonum debit debit_credit',
            'copyNameToClass' => 1,
        ],$jevDetail->jev_debit ?? null) !!}
    </td>
    <td>
        {!! \App\Swep\ViewHelpers\__form2::textboxOnly('jev_details['.$slug.'][credit]',[
            'class' => 'input-sm text-right autonum credit debit_credit',
            'copyNameToClass' => 1,
        ],$jevDetail->jev_credit ?? null) !!}
    </td>
    <td>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-default sl_btn"  data-target="#sl_modal_{{$slug}}" tabindex="-1">
                SL
                <span class="count">
                @if(!empty($jevDetail->subsidiaryLedgers))
                    ({{count($jevDetail->subsidiaryLedgers)}})
                @endif
                </span>
            </button>
            <button type="button" class="btn btn-sm btn-danger remove_row_btn" tabindex="-1"><i class="fa fa-times"></i> </button>
        </div>
    </td>
</tr>
