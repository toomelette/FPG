
<label class="no-margin">{{number_format( $totalProcurements = $data->procurements_pr_sum_abc + $data->procurements_jr_sum_abc,2)}}</label>
<div class="table-subdetail text-left">
    <table style="width: 100%">
        <tr>
            <td>PR:</td>
            <td class="text-right">
                {{number_format($data->procurements_pr_sum_abc,2)}}
            </td>
        </tr>
        <tr>
            <td>JR:</td>
            <td class="text-right">
                {{number_format($data->procurements_jr_sum_abc,2)}}
            </td>
        </tr>
    </table>
</div>
