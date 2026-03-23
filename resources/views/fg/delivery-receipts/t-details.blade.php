<table class="hide-this">
    <tbody id="details-template">
    <tr id="details-rand" data-id="rand">
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true" id="select2-details-rand" label="A" name="details[rand][description]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input type="number" class="compute" step="0.01" :input-only="true" :auto-class="true"  label="Qty" name="details[rand][qty]" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.select :select-only="true" :auto-class="true"  label="A" :options="\App\Swep\Helpers\Arrays::uoms()" name="details[rand][uom]" cols="12"/>
        </td>

        <td class="align-top">
            <x-forms.input :input-only="true"  :auto-class="true" label="" name="details[rand][unit_cost]" class="text-end autonum-rand compute" cols="12"/>
        </td>
        <td class="align-top">
            <x-forms.input :input-only="true" :auto-class="true" label="" name="details[rand][amount]" class="text-end" readonly="readonly" cols="12"/>
        </td>
        <td class="align-top">
            <button type="button" class="btn btn-danger remove_row_btn btn-sm"><i class="fa fa-times"></i></button>
        </td>
    </tr>
    </tbody>
</table>