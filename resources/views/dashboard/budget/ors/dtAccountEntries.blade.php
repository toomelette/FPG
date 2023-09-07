@php
    $grouped = $data->accountEntries->sortBy('type')->groupBy('type');
@endphp


@foreach($grouped as $type => $entries)
    <ul style="padding-left: 15px; font-size: 12px; font-family: Consolas" class="{{$type == 'DV' ? 'text-blue': 'text-green'}}">
        @if($entries->count() > 0)
            @foreach($entries as $entry)
                <li data-toggle="popup" title="{{$entry->account_code}} - {{$entry->chartOfAccount->account_title ?? 'N/A'}}" class="{{$request->account_entry == $entry->account_code ? 'background-yellow' : ''}}">
                    <span class="{{empty($entry->chartOfAccount) ? 'text-danger' : ''}}">
                        {{$entry->account_code}} -</span>
                    <span class="pull-right text-strong">
                        {{\App\Swep\Helpers\Helper::toNumber($entry->debit,2)}}
                        @if(!empty($entry->credit) && $entry->credit != 0)
                            <span title="CREDIT" class="text-danger">{{\App\Swep\Helpers\Helper::toNumber($entry->credit,2)}}</span>
                        @endif
                    </span></li>
            @endforeach
        @endif
    </ul>
@endforeach
