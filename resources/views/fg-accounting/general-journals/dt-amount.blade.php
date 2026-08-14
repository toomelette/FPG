<table style="width: 100%; font-size: 12px" class="table-borderless">
    <tr>
        <td>DR</td>
        <td class="text-end">{{Helper::toNumber($data->entries->sum('debit'),2,'-')}}</td>
    </tr>
    <tr>
        <td>CR</td>
        <td class="text-end">{{Helper::toNumber($data->entries->sum('credit'),2,'-')}}</td>
    </tr>
</table>