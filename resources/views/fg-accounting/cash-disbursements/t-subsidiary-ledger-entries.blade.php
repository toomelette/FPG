<table class="hide-this">
    <tbody id="subsidiary-ledger-template">
    <tr id="subsidiary-ledger-rand" data-id="rand">
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true"  label="" id="select2-accounts-rand" name="subsidiary_ledger[rand][account_code]" :options="[]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true"  label="Amount" class="autonum-debit-rand text-end compute" name="subsidiary_ledger[rand][debit]" cols="12" for="debit"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true"  label="Amount" class="autonum-credit-rand text-end compute" name="subsidiary_ledger[rand][credit]" cols="12" for="credit"/>
        </td>
        <td class="align-top">
            <div class="btn-group">
                <button type="button" class="btn btn-danger remove-row-btn btn-sm"><i class="fa fa-times"></i></button>
            </div>
        </td>
    </tr>
    </tbody>
</table>