<table class="hide-this">
    <tbody id="checks-template">
    <tr id="checks-rand" data-id="rand">
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true"  label="" id="select2-banks-rand" name="checks[rand][bank]" :options="[]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input label="Invoice No." :auto-class="true" name="checks[rand][check_no]" cols="12" :input-only="true"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true"  label="Amount" class="autonum-rand text-end compute" name="checks[rand][amount]" cols="12"/>
        </td>
        <td class="align-top">
            <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
        </td>
    </tr>
    </tbody>
</table>