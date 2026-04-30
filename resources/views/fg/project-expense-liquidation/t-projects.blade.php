<table class="hide-this">
    <tbody id="projects-template">
    <tr id="projects-rand" data="rand">
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true" class="select2-client-by-class" id="select2-client-rand" label="A" name="projects[rand][client]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true" id="select2-sales-invoice-rand" label="A" name="projects[rand][sales_invoice_uuid]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true" label="" name="projects[rand][amount]" class="text-end autonum-rand" cols="12"/>
        </td>
        <td class="align-top">
            <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
        </td>
    </tr>
    </tbody>
</table>