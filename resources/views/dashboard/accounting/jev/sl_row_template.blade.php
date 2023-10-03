<tr id="sl_row_{{$rowSlug}}" class="sl_row">
    <td>
        {!! \App\Swep\ViewHelpers\__form2::selectOnly('sl['.($jevDetail->slug ?? $parentSlug).']['.($rowSlug ?? $newRand).'][account]',[
            'class' => 'input-sm account '.(empty($subsidiaryLedger) ? 'except' : ''),
            'container_class' => 'select2-sm',
            'copyNameToClass' => 1,
            'id' => 'select_sa_'.$rowSlug ?? null,
            'options' => [],
            'for' => $subsidiaryLedger->sa_account_code ?? null,
        ],$subsidiaryLedger->account ?? null) !!}
        <input value="{{$subsidiaryLedger->jevDetail->account_code ?? null}}" class="account_code_header" name="sl[{{$jevDetail->slug ?? $parentSlug}}][{{$rowSlug}}][account_code_header]" hidden>
    </td>
    <td>
        {!! \App\Swep\ViewHelpers\__form2::textboxOnly('sl['.($jevDetail->slug ?? $parentSlug).']['.$rowSlug.'][debit]',[
            'class' => 'input-sm debit debit_credit text-right debit autonum',
            'copyNameToClass' => 1,
        ],$subsidiaryLedger->sl_debit ?? null) !!}
    </td>
    <td>
        {!! \App\Swep\ViewHelpers\__form2::textboxOnly('sl['.($jevDetail->slug ?? $parentSlug).']['.$rowSlug.'][credit]',[
            'class' => 'input-sm credit debit_credit text-right credit autonum',
            'copyNameToClass' => 1,
        ],$subsidiaryLedger->sl_credit ?? null) !!}
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-danger remove_row_btn" tabindex="-1"><i class="fa fa-times"></i> </button>
    </td>
</tr>