<table class="hide-this">
    <tbody id="details-template">
    <tr id="details-rand" data="rand">
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true" id="select2-details-rand" label="A" name="details[rand][description]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true" label="" name="details[rand][debit]" class="text-end autonum-rand" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true" label="" name="details[rand][credit]" class="text-end autonum-rand" cols="12"/>
        </td>
        <td class="align-top">
            <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
        </td>
    </tr>
    </tbody>
</table>