<div class="modal fade sl_modal" id="sl_modal_{{$slug}}" tabindex="-1" role="dialog" aria-labelledby="sl_modal_label">
    <div class="modal-dialog" style="width: 45%;" role="document">
        <div class="modal-content">
            <form id="sl_form_{{$slug}}" class="sl_form" data="{{$slug}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr>
                            <th>Account No. & Title</th>
                            <th style="width: 20%">Debit</th>
                            <th style="width: 20%">Credit</th>
                            <th style="width: 60px">
                                <button type="button" class="btn btn-success btn-xs add_sl_row_btn" data="{{$slug}}">
                                    <i class="fa fa-plus"></i> Add
                                </button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(!empty($jevDetail->subsidiaryLedgers))
                                @forelse($jevDetail->subsidiaryLedgers as $subsidiaryLedger)
                                    @include('dashboard.accounting.jev.sl_row_template',[
                                        'parentSlug' => $jevDetail->slug,
                                        'rowSlug' => $subsidiaryLedger->slug,
                                        'jevDetail' => $jevDetail,
                                        'subsidiaryLedger' => $subsidiaryLedger,
                                    ])
                                @empty
                                @endforelse
                            @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="text-right">TOTAL</th>
                            <th class="totals debit_total text-right">0.00</th>
                            <th class="totals credit_total text-right">0.00</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Done</button>
                </div>
            </form>
        </div>
    </div>
</div>