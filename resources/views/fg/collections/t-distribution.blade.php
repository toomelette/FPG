<table class="hide-this">
    <tbody id="distribution-template">
    <tr id="distribution-rand" data-id="rand">
        <td class="align-top">
            <x-forms.select :select-only="true" label="" id="select2-invoices-rand" :auto-class="true" label="" name="distributions[rand][invoice_uuid]" :options="[]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true"  label="Amount" class="autonum-rand text-end compute" name="distributions[rand][amount]" cols="12"/>
        </td>
        <td class="align-top">
            <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
        </td>
    </tr>
    </tbody>
</table>