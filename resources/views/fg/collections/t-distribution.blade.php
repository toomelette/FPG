<table class="hide-this">
    <tbody id="distribution-template">
    <tr id="distribution-rand" data-id="rand">
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true" label="" name="distributions[rand][ref_invoice]" :options="\App\Swep\Helpers\Arrays::invoiceTypes()" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input label="Invoice No." :auto-class="true" name="distributions[rand][invoice_no]" cols="12" :input-only="true"/>
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