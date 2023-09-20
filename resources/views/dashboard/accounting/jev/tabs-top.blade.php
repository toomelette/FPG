<div style="width: 100%">
    <div class="btn-group btn-group-justified">
        <a href="{{$rt = route('dashboard.cash_receipts.create')}}" type="button" class="btn {{ url()->current() == $rt ? 'btn-success text-strong' : 'btn-default'}}">CASH RECEIPTS</a>
        <a href="{{$rt = route('dashboard.cash_disbursements.create')}}" type="button" class="btn {{ url()->current() == $rt ? 'btn-success text-strong' : 'btn-default'}}">CASH DISBURSEMENTS</a>
        <a href="{{$rt = route('dashboard.check_disbursements.create')}}" type="button" class="btn {{ url()->current() == $rt ? 'btn-success text-strong' : 'btn-default'}}">CHECK DISBURSEMENTS</a>
        <a href="{{$rt = route('dashboard.general_journal.create')}}" type="button" class="btn {{ url()->current() == $rt ? 'btn-success text-strong' : 'btn-default'}} ">GENERAL JOURNAL</a>
    </div>
</div>