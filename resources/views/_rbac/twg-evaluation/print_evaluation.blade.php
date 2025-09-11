@php
    $rand = \Illuminate\Support\Str::random();
    $chunkBy = 3;
@endphp
@extends('printables.print_layouts.print_layout_main')

@section('wrapper')
    <style>
        .circle {
            position: absolute; /* Allow positioning relative to the page */
            top: 500; /* Adjust as needed for vertical position */
            left: 50; /* Center the circle horizontally */
            transform: translateX(-50%); /* Further center the circle horizontally */

            height: 50px; /* Match width for a perfect circle */
            border-radius: 50%; /* Create a perfect circle */
            border: 2px solid blue;
            z-index: 10; /* Ensure it stays on top of the target element */
            @if($eval->winning_supplier_slug == null)
            display : none;
            @endif
        }
    </style>


    <div class="circle"></div>
<div style="font-family: Cambria; margin-top: 100px; width: 7.5in">
    <h3 class="text-center text-strong">RBAC FORM - TWG EVALUATION AND RECOMMENDATION</h3>
    <table class="tbl-padded" style="width: 100%; font-size: 14px">
        <tr>
            <td style="width: 50px">Item/s:</td>
            <td class="text-strong">
                <u>{{$eval->concat_items}}</u>
            </td>
        </tr>
    </table>
    <table class="tbl-padded" style="width: 100%; font-size: 12px">
        <tr>
            <td style="width: 100px">Approved budget:</td>
            <td style="width: 35%" class="text-strong">
                <u>{{Helper::toNumber($eval->abc)}}</u>
            </td>
            <td style="width: 150px;">
                Mode of Procurement:
            </td>
            <td class="text-strong">
                <u>{{$eval->mode_of_procurement}}</u>
            </td>
        </tr>
    </table>
    <table class="tbl-padded" style="width: 100%; font-size: 12px">
        <tr>
            <td style="width: 70%">Winning Supplier/s:</td>
            <td>Bid Price/s:</td>
        </tr>
        <tr>
            <td class="text-strong"><u>{{$eval->winning_supplier}}</u></td>
            <td class="text-strong"><u>{{Helper::toNumber($eval->bid_price)}}</u></td>
        </tr>
    </table>
    <br>
    @php
        $groupedBySupplier = $eval->offers->groupBy('supplier')->mapWithKeys(function ($data){
            return [
                $data->first()->supplier_slug => $data->first()->relSupplier,
            ];
        });
        $groupedByItems = $eval->offers->groupBy('item_slug');
        $chunkedSuppliers = $groupedBySupplier->chunk(3);
    @endphp

    @foreach($chunkedSuppliers as $chunkedSupplier)
        <table class="tbl-bordered tbl-padded" style="font-size: 12px; width: 100%">
            <thead>
            <tr>
                <th class="text-center no-border-all" style="width: 50px; padding: 0"></th>
                <th class="text-center no-border-all" style="padding: 0"></th>
                @for($i = 0; $i < $chunkBy ; $i++)
                    <th class="no-border-all" style="width: {{(87/$chunkBy)*(2/3)}}%; padding: 0;"></th>
                    <th class="no-border-all" style="width: {{(87/$chunkBy)*(1/3)}}%; padding: 0;"></th>
                @endfor

            </tr>
            <tr>
                <th class="text-center" style="width: 50px">Item No.</th>
                <th class="text-center">Qty</th>
                @for($i = 0; $i < $chunkBy ; $i++)
                    @php
                        $supplier = $chunkedSupplier->values()->get($i)
                    @endphp
                    @if(!empty($supplier))
                        <th colspan="2" class="text-center " style="vertical-align: top" >
                            <span  {{$supplier->slug == $eval->winning_supplier_slug ? 'id=winner' : ''}}>{{$supplier->name}}</span>
                        </th>
                    @else
                        <th colspan="2" class="text-center " style="width: {{90/$chunkedSupplier->count()}}%; vertical-align: top" >
                            <span></span>
                        </th>
                    @endif
                @endfor

            </tr>
            </thead>
            <tbody>

            @forelse($groupedByItems as $items)
                @php
                    $item = $items->first();
                @endphp
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-center">{{$item->qty}}</td>
                    @for($i = 0; $i < $chunkBy ; $i++)
                        @php
                            $supplier = $chunkedSupplier->values()->get($i);

                        @endphp
                        @if(!empty($supplier))
                            @php
                                $amount = $items->where('supplier_slug',$supplier->slug)->first()->amount ?? 0
                            @endphp
                            <td class="text-center" style="font-size: 10px">{{$items->where('supplier_slug',$supplier->slug)->first()->offer}}</td>
                            <td class="text-right">{{Helper::toNumber($amount * $item->qty)}}</td>
                        @else
                            <td class="text-center" style="font-size: 10px"></td>
                            <td class="text-right"></td>
                        @endif
                    @endfor
                </tr>
            @empty
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td class="no-border-all"></td>
                <td class="no-border-all"></td>
                @for($i = 0; $i < $chunkBy ; $i++)
                    @php
                        $supplier = $chunkedSupplier->values()->get($i);

                    @endphp
                    @if(!empty($supplier))
                        <th class="no-border-all"></th>
                        <th class="text-right no-border-all" style="{{$supplier->slug == $eval->winning_supplier_slug ? 'background-color: yellow' : ''}};border-bottom: 3px double black !important; border-spacing: 5px">{{Helper::toNumber($eval->offers->where('supplier_slug',$supplier->slug)->sum('total_amount_per_item'))}}</th>
                    @else
                        <th class="no-border-all "></th>
                        <th class="no-border-all"></th>
                    @endif
                @endfor

            </tr>
            </tfoot>
        </table>
        <br>
    @endforeach



    <br><br>
    <table style="width: 100%; font-size: 12px" class="tbl-padded">
        <tr>
            <td style="width: 100px;">Note:</td>
            <td class="b-bottom">{{$eval->note}}</td>
        </tr>
        <tr>
            <td>Justification:</td>
            <td class="b-bottom">{{$eval->justification}}</td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; font-size: 12px" class="tbl-padded">
        <tr>
            <td>Recommending Approval:</td>
        </tr>
        <tr>
            <td class="text-center">
                <br><br>
                <u class="text-strong">{{$eval->recommending_approval}}</u><br>
                TWG-MEMBER
            </td>
        </tr>
    </table>
</div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
            print();
        })

        var rect = $("#winner").offset();
        console.log(rect);
        $(".circle").css("top",rect.top-20);
        $(".circle").css("left",rect.left+70);
        $(".circle").css("width",$("#winner").width()+30);
    </script>
@endsection