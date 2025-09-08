@php
$rand = Str::random();
@endphp
<h4 class="text-strong">{{Carbon::parse($month)->format('F Y')}}</h4>
<table class="table table-bordered table-sm" id="deduction-table-{{$rand}}">
    <thead>
    <tr>
        <th>Employee</th>
        @forelse($deductions as $deduction)
            <th class="text-center">{{$deduction->deduction_code}} <br> <small>{{$deduction->description}}</small></th>
        @empty
        @endforelse
    </tr>
    </thead>
    <tbody>
    @forelse($employees as $employee)
        <tr>
            <td>{{$employee->full['LFEMi']}}</td>
            @forelse($deductions as $deduction)
                <td class="text-center">
                    <input type="text" class="form-control autonum-{{$rand}} text-end amt" data="{{$deduction->deduction_code}}" placeholder="">
                </td>
            @empty
            @endforelse
        </tr>
    @empty
    @endforelse
    </tbody>
    <tfoot>
    <tr>
        <th>Total</th>
        @forelse($deductions as $deduction)
            <th class="text-end total-html" data="{{$deduction->deduction_code}}">0.00</th>
        @empty
        @endforelse
    </tr>
    </tfoot>
</table>

<script type="text/javascript">
    $(".autonum-{{$rand}}").each(function(){
        new AutoNumeric(this, autonum_settings);
    });

    $(".amt").on('change keyup',function (){
        let totals = [];
        let cur = $(this);
        let dataAttr = cur.attr('data');
        let dataAttrCommons = $("#deduction-table-{{$rand}} input[data='"+dataAttr+"']");
        let allAmt = $("#deduction-table-{{$rand}} .amt");
        allAmt.each(function (){
            if(typeof totals[$(this).attr('data')] === 'undefined'){
                totals[$(this).attr('data')] = 0;
            }
            totals[$(this).attr('data')] = sanitizeAutonum($(this).val()) + totals[$(this).attr('data')];
        });
        $("#deduction-table-{{$rand}} tfoot th.total-html").each(function (){
            $(this).html($.number(totals[$(this).attr('data')],2));
        });
    });
</script>