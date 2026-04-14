<table class="hide-this">
    <tbody id="entries-template">
    <tr id="checks-rand" data-id="rand">
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true"  label="" id="select2-accounts-rand" name="entries[rand][account_code]" :options="[]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true"  label="Amount" class="autonum-debit-rand text-end compute" name="entries[rand][debit]" cols="12" for="debit"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true"  label="Amount" class="autonum-credit-rand text-end compute" name="entries[rand][credit]" cols="12" for="credit"/>
        </td>
        <td class="align-top">
            <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
        </td>
    </tr>
    </tbody>
</table>